<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function create()
    {
        $companies = Company::all();
        return view('invitations.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Base validation for all roles
        $request->validate([
            'name'     => 'required|string|min:2|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => ['required', Rule::in(['admin', 'member'])],
        ]);

        if ($user->role === 'superadmin') {
            // If no company selected, company_name is required
            if (!$request->company_id) {
                $request->validate([
                    'company_name' => 'required|string|min:2',
                ]);
            } else {
                $request->validate([
                    'company_id' => 'exists:companies,id',
                ]);
            }
        } else {
            // Admin - force their own company
            $request->merge(['company_id' => $user->company_id]);
        }

        $companyId = $request->company_id;

        // Create new company if superadmin selected none
        if (!$companyId) {
            $company = Company::create([
                'name' => $request->company_name,
                'slug' => Str::slug($request->company_name),
            ]);
            $companyId = $company->id;
        }

        // Create the user
        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'company_id' => $companyId,
        ]);

        return back()->with('success', 'User invited successfully.');
    }

    // private function canInvite(User $user, string $role, ?int $companyId): bool
    // {
    //     // SuperAdmin can invite anyone to any company (existing or new)
    //     if ($user->role === 'superadmin') {
    //         return true;
    //     }

    //     // Admin can invite admin or member to their own company
    //     if ($user->role === 'admin') {
    //         if ($companyId && $user->company_id === $companyId && in_array($role, ['admin', 'member'])) {
    //             return true;
    //         }
    //         // Admin cannot invite to other companies or create new companies
    //         return false;
    //     }

    //     // Members can't invite
    //     return false;
    // }
}
