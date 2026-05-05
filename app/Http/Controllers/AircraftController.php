<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateAircraftRequest;
use App\Http\Requests\UpdateAircraftRequest;
use App\Models\Aircraft;
use App\Models\EngineType;
use App\Enums\AircraftType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\AircraftService;

class AircraftController extends Controller
{
    public function __construct(private AircraftService $aircraftService) {}

    /**
     * Display the specified aircraft.
     *
     * @param Aircraft $aircraft
     * @return View
     */
    public function show(Aircraft $aircraft): View
    {
        $aircraft->load(['engineType', 'fuelType']);

        return view('aircraft.show', [
            'aircraft' => $aircraft,
        ]);
    }

    /**
     * Show the form for creating a new aircraft.
     *
     * @return View
     */
    public function create(): View
    {
        return view('aircraft.create', [
            'aircraftTypes' => AircraftType::cases(),
            'engineTypes' => EngineType::query()->orderBy('type')->get(),
        ]);
    }

    /**
     * Store a newly created aircraft in storage.
     *
     * @param CreateAircraftRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAircraftRequest $request, Aircraft $aircraft): RedirectResponse
    {
        $createdAircraft = $aircraft->create([
            ...$request->validated(),
            'engine_type_id' => AircraftService::setAircraftEngineBasedOnType($request->validated('type')),
        ]);
            
        return redirect()->route('dashboard.aircraft.show', $createdAircraft)->with('status', 'Aircraft created successfully');
    }

    public function edit(Aircraft $aircraft): View
    {
        $aircraft->load(['engineType', 'fuelType']);

        return view('aircraft.edit', [
            'aircraft' => $aircraft,
            'aircraftTypes' => AircraftType::cases(),
            'engineTypes' => EngineType::query()->orderBy('type')->get(),
        ]);
    }

    public function update(UpdateAircraftRequest $request, Aircraft $aircraft): RedirectResponse
    {
        $aircraft->update([
            ...$request->validated(),
            'engine_type_id' => AircraftService::setAircraftEngineBasedOnType($request->validated('type')),
        ]);

        return redirect()->route('dashboard.aircraft.show', $aircraft)->with('status', 'Aircraft updated successfully');
    }

    public function delete(Aircraft $aircraft): RedirectResponse
    {
        $this->aircraftService->deleteAircraftAndLessons($aircraft);

        return redirect()->route('dashboard.index')->with('status', 'Aircraft removed from the fleet.');
    }
}
