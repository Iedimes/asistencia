<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Functionary\BulkDestroyFunctionary;
use App\Http\Requests\Admin\Functionary\DestroyFunctionary;
use App\Http\Requests\Admin\Functionary\IndexFunctionary;
use App\Http\Requests\Admin\Functionary\StoreFunctionary;
use App\Http\Requests\Admin\Functionary\UpdateFunctionary;
use App\Models\Functionary;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FunctionariesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFunctionary $request
     * @return array|Factory|View
     */
    public function index(IndexFunctionary $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Functionary::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'ci', 'full_name', 'user_name'],

            // set columns to searchIn
            ['id', 'ci', 'full_name', 'user_name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.functionary.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.functionary.create');

        return view('admin.functionary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFunctionary $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFunctionary $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Functionary
        $functionary = Functionary::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/functionaries'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/functionaries');
    }

    /**
     * Display the specified resource.
     *
     * @param Functionary $functionary
     * @throws AuthorizationException
     * @return void
     */
    public function show(Functionary $functionary)
    {
        $this->authorize('admin.functionary.show', $functionary);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Functionary $functionary
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Functionary $functionary)
    {
        $this->authorize('admin.functionary.edit', $functionary);


        return view('admin.functionary.edit', [
            'functionary' => $functionary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFunctionary $request
     * @param Functionary $functionary
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFunctionary $request, Functionary $functionary)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Functionary
        $functionary->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/functionaries'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/functionaries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFunctionary $request
     * @param Functionary $functionary
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyFunctionary $request, Functionary $functionary)
    {
        $functionary->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFunctionary $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyFunctionary $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Functionary::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
