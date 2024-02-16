<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\ResetsPasswords;


class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function showLinkRequestForm()
    {
        // Logika za prikazivanje forme za resetovanje lozinke

        // Ovo će se ispisati u logu ili HTTP odgovoru kada se pozove ruta
        // http://127.0.0.1:8000/api/password/reset
        \Log::info('Metoda radi');

        // Prikazivanje prilagođenog odgovora
        return Response::json(['message' => 'Metoda radi'], 200);
    }
}
