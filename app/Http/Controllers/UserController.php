<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$query = User::query();

		// Filter Role
		if ($request->filled('role') && $request->role != 'semua') {
			$query->where('role', $request->role);
		}

		// Filter Status Active
		if ($request->filled('status') && $request->status != 'semua') {
			$query->where('is_active', $request->status === 'active' ? true : false);
		}

		// Search
		if ($request->filled('search')) {
			$search = $request->search;
			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('email', 'like', "%{$search}%");
			});
		}

		$perPage = $request->integer('per_page', 10);

		$users = $query
			->orderBy('name')
			->paginate($perPage)
			->withQueryString();

		return view('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreUserRequest $request)
	{
		$validated = $request->validated();

		User::create([
			'name'      => $validated['name'],
			'email'     => $validated['email'],
			'role'      => $validated['role'],
			'password'  => Hash::make($validated['password']),
			'phone'     => $validated['phone'] ?? null,
			'is_active' => $request->boolean('is_active'),
		]);

		return redirect()
			->route('users.index')
			->with('success', 'User berhasil ditambahkan.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(User $user)
	{
		return view('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(User $user)
	{
		return view('users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateUserRequest $request, User $user)
	{
		$validated = $request->validated();

		$data = [
			'name'      => $validated['name'] ?? $user->name,
			'email'     => $validated['email'] ?? $user->email,
			'role'      => $validated['role'] ?? $user->role,
			'phone'     => $validated['phone'] ?? $user->phone,
			'is_active' => $request->boolean('is_active'),
		];

		// Only update password if provided
		if (!empty($validated['password'])) {
			$data['password'] = Hash::make($validated['password']);
		}

		$user->update($data);

		return redirect()
			->route('users.index')
			->with('success', 'User berhasil diperbarui.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(User $user)
	{
		// Prevent deleting yourself
		if ($user->id === Auth::id()) {
			return redirect()
				->route('users.index')
				->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
		}

		$user->delete();

		return redirect()
			->route('users.index')
			->with('success', 'User berhasil dihapus.');
	}
}
