<?php
class Promotions
{
    use Controller;

    public function index(): void
    {

        $p = new Promotion();
        $promos = $p->getpromos();

        $this->view('promotions', [
            'promos' => $promos
        ]);
    }
}