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

class EndpointController extends Controller
{
    protected string $viewPrefix = 'Endpoint';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $endpoints = Endpoint::query()
            ->with([
                'cluster',
                'container.cluster',
            ])
            ->whereDoesntHave('type', function ($query) {
                $query->whereIn('code', [EndpointType::FAT(), EndpointType::JB()]);
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
            $sv->create($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('endpoint.index');
    }

    public function show(Endpoint $endpoint): Response
    {
        $endpoint->load('cluster', 'container.cluster', 'ports.toPorts.endpoint');

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
            $sv->update($endpoint, $request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('endpoint.index');
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

        return redirect()->route('endpoint.index');
    }
}
