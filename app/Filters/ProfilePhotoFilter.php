<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\ProfilModel;

class ProfilePhotoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Only run if the user is logged in
        if ($session->get('logged_in')) {
            // To avoid hitting the DB on every single request,
            // we can check if the photo is already in the session.
            // Or, for real-time updates, we can fetch it every time.
            // Let's fetch it every time to ensure it's always current.
            
            $profilModel = new ProfilModel();
            $profil = $profilModel->where('id_user', $session->get('id_user'))->first();

            // Update the session with the latest photo
            $session->set('foto', $profil['foto'] ?? null);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
