<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryPartner;
use Illuminate\Support\Str;

class DeliveryPartnerController extends Controller
{
    public function index()
    {
        $partners = DeliveryPartner::where('user_id', auth()->id())->get()->keyBy('slug');
        return view('backend.delivery_partner.index', compact('partners'));
    }

    public function save(Request $request, $slug)
    {
        $request->validate([
            'slug' => 'required|in:pathao,ecourier,steadfast,redx'
        ]);

        $partner_name = ucfirst($slug);
        $fields = [];

        switch ($slug) {
            case 'pathao':
                $fields = $request->only(['mail', 'password', 'client_id', 'client_secret', 'store_id']);
                break;
            case 'ecourier':
                $fields = $request->only(['user_id', 'api_key', 'api_secret']);
                break;
            case 'steadfast':
                $fields = $request->only(['api_key', 'api_secret']);
                break;
            case 'redx':
                $fields = $request->only(['jwt_token']);
                break;
        }

        DeliveryPartner::updateOrCreate(
            ['user_id' => auth()->id(), 'slug' => $slug],
            [
                'partner_name' => $partner_name,
                'slug' => $slug,
                'credentials' => $fields,
                'status' => true
            ]
        );

        return back()->with('success', $partner_name . ' configured successfully!');
    }
}