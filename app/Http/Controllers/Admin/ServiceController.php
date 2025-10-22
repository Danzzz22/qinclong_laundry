<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

// Notifications
use App\Notifications\ServiceCreated;
use App\Notifications\ServiceDeleted;
use App\Notifications\ServicePriceChanged;
use App\Notifications\ServiceToggled;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $services = Service::query();

        if ($q !== '') {
            $qLower  = mb_strtolower($q, 'UTF-8');
            $tokens  = preg_split('/\s+/', $qLower, -1, PREG_SPLIT_NO_EMPTY);

            $syn = [
                'setrika'  => 'strika',
                'seterika' => 'strika',
                'ekspres'  => 'express',
                'kilat'    => 'express',
            ];

            $terms = [];
            foreach ($tokens as $t) {
                $terms[] = $t;
                if (isset($syn[$t])) $terms[] = $syn[$t];
            }
            $terms = array_values(array_unique($terms));

            $services->where(function ($w) use ($terms, $qLower) {
                foreach ($terms as $t) {
                    $w->orWhereRaw('LOWER(name) LIKE ?', ["%{$t}%"])
                      ->orWhereRaw('LOWER(unit) LIKE ?', ["%{$t}%"]);
                    if (Schema::hasColumn('services', 'description')) {
                        $w->orWhereRaw('LOWER(description) LIKE ?', ["%{$t}%"]);
                    }
                }
                $w->orWhereRaw('SOUNDEX(name) = SOUNDEX(?)', [$qLower]);
            });
        }

        $services = $services->orderByDesc('created_at')->get();

        return view('admin.services.index', compact('services', 'q'));
    }

    public function create()
    {
        return view('admin.services.create', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'integer', 'min:0'],
            'unit'        => ['nullable', 'string', 'max:50'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        if (!Schema::hasColumn('services', 'description')) unset($data['description']);

        // simpan gambar -> WEBP jika bisa, fallback file asli
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeAsWebp($request->file('image'), $data['name'] ?? 'service');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $service = Service::create($data);

        // 🔔 layanan baru
        $this->notifyAllUsers(new ServiceCreated([
            'id'        => $service->id,
            'name'      => $service->name,
            'price'     => (int) $service->price,
            'unit'      => (string) ($service->unit ?? ''),
            'is_active' => (bool) $service->is_active,
        ]));

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'integer', 'min:0'],
            'unit'        => ['nullable', 'string', 'max:50'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        if (!Schema::hasColumn('services', 'description')) unset($data['description']);

        $oldPrice = (int) $service->price;

        // handle gambar
        if ($request->hasFile('image')) {
            // hapus lama
            if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
                Storage::disk('public')->delete($service->image_path);
            }
            // simpan baru
            $data['image_path'] = $this->storeAsWebp($request->file('image'), $data['name'] ?? $service->name ?? 'service');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $service->update($data);

        // 🔔 harga berubah
        if ((int) $service->price !== $oldPrice) {
            $this->notifyAllUsers(new ServicePriceChanged([
                'id'        => $service->id,
                'name'      => $service->name,
                'old_price' => $oldPrice,
                'new_price' => (int) $service->price,
                'unit'      => (string) ($service->unit ?? ''),
            ]));
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $payload = ['id' => $service->id, 'name' => $service->name];

        if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();

        // 🔔 layanan dihapus
        $this->notifyAllUsers(new ServiceDeleted($payload));

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    public function toggle(Service $service)
    {
        $service->update(['is_active' => ! (bool) $service->is_active]);

        // 🔔 aktif/nonaktif
        $this->notifyAllUsers(new ServiceToggled([
            'id'        => $service->id,
            'name'      => $service->name,
            'is_active' => (bool) $service->is_active,
        ]));

        return back()->with('success', 'Status layanan diperbarui.');
    }

    /** Kirim notifikasi ke semua user (role=user jika ada kolom role). */
    private function notifyAllUsers($notification): void
    {
        /** @var \Illuminate\Notifications\Notification $notification */
        $query = User::query();
        if (Schema::hasColumn('users', 'role')) {
            $query->where('role', 'user');
        }
        $recipients = $query->get(['id', 'name', 'email']);
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, $notification);
        }
    }

    /**
     * Simpan upload ke disk 'public' sebagai WEBP (jika GD tersedia).
     * Bila GD tidak ada / gagal konversi, fallback simpan file asli.
     * Return: relative path "services/xxx.webp" atau "services/xxx.jpg/png".
     */
    private function storeAsWebp(UploadedFile $file, string $nameHint = 'service'): string
    {
        // Jika GD tidak tersedia → simpan original
        if (!\function_exists('\imagecreatefromstring') || !\function_exists('\imagewebp')) {
            return $file->store('services', 'public');
        }

        // Baca binary
        $binary = @\file_get_contents($file->getRealPath());
        if ($binary === false) {
            return $file->store('services', 'public');
        }

        // Buat resource GD (prefiks \ agar tidak ke-namespace)
        $img = @\imagecreatefromstring($binary);
        if ($img === false) {
            return $file->store('services', 'public');
        }

        // Jaga alpha (penting untuk PNG → WEBP)
        if (\function_exists('\imagepalettetotruecolor')) {
            @\imagepalettetotruecolor($img);
        }
        @\imagealphablending($img, true);
        @\imagesavealpha($img, true);

        $filename = Str::slug($nameHint).'-'.Str::lower(Str::random(6)).'.webp';
        $path = 'services/'.$filename;

        // Tulis ke file tmp, lalu put ke storage
        $tmp = \tempnam(\sys_get_temp_dir(), 'webp_') ?: (\sys_get_temp_dir().'/'.Str::random(8));
        $ok  = @\imagewebp($img, $tmp, 85);
        @\imagedestroy($img);

        if (!$ok) {
            @\unlink($tmp);
            return $file->store('services', 'public');
        }

        $contents = @\file_get_contents($tmp);
        @\unlink($tmp);

        Storage::disk('public')->put($path, $contents);
        return $path;
    }
}
