<?php

namespace App\Http\Controllers;

use App\Models\ModeratorObject;
use Illuminate\Http\Request;

class ModeratorObjectController extends Controller
{
    public function index()
    {
        $objects = ModeratorObject::with(['region', 'city', 'buildingType', 'street'])->paginate(10);
        return view('moderator.objects.index', compact('objects'));
    }

    public function create()
    {
        return view('moderator.objects.create', [
            'regions' => \App\Models\Region::all(),
            'cities' => \App\Models\City::all(),
            'buildingTypes' => \App\Models\BuildingType::all(),
            'streets' => \App\Models\Street::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'building_type_id' => 'required|exists:building_types,id',
            'street_id' => 'required|exists:streets,id',
            'house' => 'required|string|max:255',
            'corpus' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:on_moderation,published',
        ]);

        ModeratorObject::create($data);

        return redirect()->route('moderator.objects.index')->with('success', 'Объект создан.');
    }

    public function edit(ModeratorObject $moderatorObject)
    {
        return view('moderator.objects.edit', [
            'object' => $moderatorObject, // Передаем объект в шаблон
            'regions' => \App\Models\Region::all(),
            'cities' => \App\Models\City::all(),
            'buildingTypes' => \App\Models\BuildingType::all(),
            'streets' => \App\Models\Street::all(),
        ]);
    }


    public function update(Request $request, ModeratorObject $moderatorObject)
    {
        $data = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'building_type_id' => 'required|exists:building_types,id',
            'street_id' => 'required|exists:streets,id',
            'house' => 'required|string|max:255',
            'corpus' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:on_moderation,published',
        ]);

        $moderatorObject->update($data);

        return redirect()->route('moderator.objects.index')->with('success', 'Объект обновлен.');
    }
    public function destroy(ModeratorObject $moderatorObject)
    {
        try {
            $moderatorObject->delete();
            return redirect()->route('moderator.objects.index')->with('success', 'Объект удален.');
        } catch (\Exception $e) {
            return redirect()->route('moderator.objects.index')->with('error', 'Ошибка при удалении объекта: ' . $e->getMessage());
        }
    }

}
