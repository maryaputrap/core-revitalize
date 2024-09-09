<?php

namespace App\Http\Controllers;

use App\Enums\OptionReference\EndpointType;
use App\Http\Requests\EndpointRequest;
use App\Models\Endpoint;
use App\Services\EndpointService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class FDTController extends Controller
{
    protected string $viewPrefix = 'FDT';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $endpoints = Endpoint::query()
            ->with([
                'container.cluster',
            ])
            ->whereHas('type', function ($query) {
                $query->where('code', EndpointType::FAT());
            })
            ->paginate();

        return Inertia::render($this->viewComponent('Index'), [
            'endpoints' => $endpoints
        ]);
    }

    public function create(): Response
    {
        return Inertia::render($this->viewComponent('Form'));
    }

    public function store(EndpointRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {

            $sv = new EndpointService();
            $sv->create($request->validated(), prefix: 'CORE', duplicate: true);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('fdt.index');
    }

    public function show(Endpoint $endpoint): Response
    {
        $endpoint->load('container.cluster', 'ports.toPorts.endpoint');

        return Inertia::render($this->viewComponent('Show'), [
            'endpoint' => $endpoint
        ]);
    }

    public function edit(Endpoint $endpoint): Response
    {
        $endpoint->load('container.cluster');

        return Inertia::render($this->viewComponent('Form'), [
            'endpoint' => $endpoint
        ]);
    }

    public function update(Endpoint $endpoint, EndpointRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $sv = new EndpointService();
            $sv->update($endpoint, $request->validated(), prefix: 'CORE', duplicate: true);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('fdt.index');
    }

    public function destroy(Endpoint $endpoint): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $sv = new EndpointService();
            $sv->delete($endpoint);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('fdt.index');
    }
}
