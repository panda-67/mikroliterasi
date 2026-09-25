<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PersonController extends Controller implements HasMiddleware
{
    public function __construct(
        protected PersonService $personService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: [
                'dashboardIndex',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]),
        ];
    }

    public function dashboardIndex()
    {
        Gate::authorize('viewAny', Person::class);

        $people = $this->personService->getAll(12);

        return view('dashboard.people.index', compact('people'));
    }

    public function index()
    {
        $people = $this->personService->getAll(12);

        return view('people.index', compact('people'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Person::class);

        return view('people.create', [
            'fromDashboard' => $request->boolean('fromDashboard')
        ]);
    }

    public function store(PersonRequest $request)
    {
        Gate::authorize('create', Person::class);

        $person = $this->personService->create(
            $request->validated()
        );

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.people.index')
                ->with('success', 'Person berhasil dibuat.');
        }

        return redirect()
            ->route('people.show', $person->slug)
            ->with(
                'success',
                'Person berhasil dibuat.'
            );
    }

    public function show(Person $person)
    {
        $person->load([
            'researchProjects',
            'publications',
        ]);

        return view('people.show', compact('person'));
    }

    public function edit(Request $request, Person $person)
    {
        Gate::authorize('update', $person);

        $fromDashboard = $request->boolean('fromDashboard');

        return view('people.edit', compact(
            'person',
            'fromDashboard'
        ));
    }

    public function update(
        PersonRequest $request,
        Person $person
    ) {
        Gate::authorize('update', $person);

        $person = $this->personService->update(
            $person,
            $request->validated()
        );

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.people.index')
                ->with('success', 'Person berhasil diperbarui.');
        }

        return redirect()
            ->route('people.show', $person->slug)
            ->with(
                'success',
                'Person berhasil diperbarui.'
            );
    }

    public function destroy(Request $request, Person $person)
    {
        Gate::authorize('delete', $person);

        $this->personService->delete($person);

        if ($request->boolean('fromDashboard')) {
            return redirect()
                ->route('dashboard.people.index')
                ->with('success', 'Person berhasil dihapus.');
        }


        return redirect()
            ->route('people.index')
            ->with(
                'success',
                'Person berhasil dihapus.'
            );
    }
}
