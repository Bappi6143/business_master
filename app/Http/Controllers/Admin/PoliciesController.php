<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;

class PoliciesController extends Controller
{
    public function index()
    {
        // Check if there's an existing policy
        $policy = Policy::first();
        return view('backend.policies.index', compact('policy'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'terms_conditions' => 'required|string',
            'privacy_policy' => 'required|string',
            'refund_policy' => 'required|string',
        ]);

        // Check if policy exists and update, otherwise create a new one
        $policy = Policy::first();

        if ($policy) {
            // Update existing policy
            $policy->update([
                'terms_conditions' => $request->terms_conditions,
                'privacy_policy' => $request->privacy_policy,
                'refund_policy' => $request->refund_policy,
            ]);
            return redirect()->route('policies.index')->with('success', 'Policies updated successfully.');
        } else {
            // Create new policy
            Policy::create([
                'terms_conditions' => $request->terms_conditions,
                'privacy_policy' => $request->privacy_policy,
                'refund_policy' => $request->refund_policy,
            ]);
            return redirect()->route('policies.index')->with('success', 'Policies saved successfully.');
        }
    }
    
    public function destroy($id)
    {
        // Logic to delete a policy if necessary
    }
}
