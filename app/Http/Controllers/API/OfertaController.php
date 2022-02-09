<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Oferta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Oferta as OfertaResource;
use DateTime;
use App\Clase\InformatiiProduse;
use Illuminate\Support\Facades\DB;

class OfertaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oferte = Oferta::all();

        return $this->sendResponse(OfertaResource::collection($oferte), 'Products retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emite(Request $request)
    {
        $prima = $this->cotatie($request)->getData();
        // die(print_r($prima->getData(), true));
        if (!$prima->success)
        {
            return $this->sendError($prima->message, $prima->data);
        }
        $prima = $prima->data->prima;

        $input = $request->all();

        $validator = Validator::make($input, [
            'valuta'        => ['required', Rule::in(['RON', 'EUR', 'USD'])],
            'campOptional'  => 'nullable|max:255'
        ]);

        if($validator->fails()){
            return $this->sendError('Eroare validare date.', $validator->errors());
        }

        $Produs = new InformatiiProduse('Produs1');

        $DB_input = [
            'Serie'             => $Produs->Serie,
            'DataEmitere'       => date("Y-m-d"),
            'DataStart'         => $input['start'],
            'DataEnd'           => $input['end'],
            'Prima'             => $prima,
            'SumaAsigurata'     => $input['sumaAsigurata'],
            'Valuta'            => $input['valuta'],
            'PachetAsigurare'   => $input['pachet'],
            'Optional'          => (isset($input['campOptional']) ? $input['campOptional'] : "")
        ];
        $oferta = Oferta::create($DB_input);

        $oferta = Oferta::find($oferta->IdOferta);

        return $this->sendResponse(new OfertaResource($oferta), 'Oferta creata cu succes.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oferta = Oferta::find($id);

        if (is_null($oferta)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new OfertaResource($oferta), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Oferta $oferta)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'start' => 'required',
            'end' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $oferta->DataStart = $input['start'];
        $oferta->DataEnd = $input['end'];
        $oferta->save();

        return $this->sendResponse(new OfertaResource($oferta), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oferta $oferta)
    {
        $oferta->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }

    public function cotatie(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'start'         => 'required|date',
            'end'           => 'required|date|after_or_equal:start',
            'sumaAsigurata' => 'required|integer|gt:0',
            'pachet'        => ['required', Rule::in([1, 2, 3, 4])]
        ]);

        if($validator->fails()){
            return $this->sendError('Eroare validare date.', $validator->errors());
        }

        $prima = 0;

        $d1 = new DateTime($input['start']);
        $d2 = new DateTime($input['end']);
        $nrZile = $d2->diff($d1)->format("%a");

        switch ($input['pachet'])
        {
            case 1: $prima = $input['sumaAsigurata'] * 0.01; break;
            case 2: $prima = $input['sumaAsigurata'] * 0.017; break;
            case 3: $prima = $input['sumaAsigurata'] * 0.022; break;
            case 4: $prima = $input['sumaAsigurata'] * 0.025; break;
        }

        $prima = round($prima / 365 * $nrZile);

        return $this->sendResponse(['prima' => $prima], 'Cotatie efectuata cu succes.');
    }
}
