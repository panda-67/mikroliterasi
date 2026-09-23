<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PersonController extends Controller implements HasMiddleware
{
    public function __construct(
        protected PersonService $personService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: [
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]),
        ];
    }

    public function index()
    {
        $people = $this->personService->getAll(12);

        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(PersonRequest $request)
    {
        $person = $this->personService->create(
            $request->validated()
        );

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

    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    public function update(
        PersonRequest $request,
        Person $person
    ) {
        $person = $this->personService->update(
            $person,
            $request->validated()
        );

        return redirect()
            ->route('people.show', $person->slug)
            ->with(
                'success',
                'Person berhasil diperbarui.'
            );
    }

    public function destroy(Person $person)
    {
        $this->personService->delete($person);

        return redirect()
            ->route('people.index')
            ->with(
                'success',
                'Person berhasil dihapus.'
            );
    }
}
