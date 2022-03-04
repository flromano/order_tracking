<?php

namespace App\Services;

use App\Models\Tracking;
use Illuminate\Support\Facades\Http;

class TrackingService
{

    public function tracking( $code ): array
    {
        $response = Http::get("https://www.linkcorreios.com.br/", [
            'id' => $code
        ]);

        if ($response->ok()) {

            $body = $response->body();

            //remover caracteres especiais
            $body = preg_replace( "/\r|\n|\t/", "", $body );

            //retirar dados
            preg_match_all('/<ul class=\"linha_status\" style=\"\">(.*?)<\/ul>/i', $body, $data);

            $tracking = array_map( function ( $item ) {

                //remove as tag <li></li>
                preg_match_all('/<li>(.*?)<\/li>/', $item, $row);

                //data e tempo
                $datetime = explode('|', $row[1][1]);
                preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/', $datetime[0], $date);
                preg_match('/([0-9]{2}):([0-9]{2})/', $datetime[1], $time);

                //cidade / estado
                preg_match('/[A-Za-z]+[a-zA-Z ]+ ?\/ ?[A-Z]{2}/', $row[1][2], $city);

                return [
                    'status' => trim(strip_tags(explode(':', $row[1][0], 2)[1])),
                    'date' => $date[0],
                    'time'=> $time[0],
                    'city' => is_array($city) && count($city) ? $city[0] : null,
                ];
            }, $data[1]);

            return [
                'tracking'=> $tracking,
                'status'=> $this->status($tracking),
                'last_update' => $this->lastUpdate($tracking)
            ];

        }

        return [
            'tracking'=> null,
            'status'=> null,
            'last_update' => null
        ];

    }

    public function lastUpdate( $tracking ) {
        return is_array($tracking) && count($tracking) ? array_values($tracking)[0] : null;
    }

    public function status ( $tracking ) {

        $last = $this->lastUpdate($tracking);

        //Aguardando Postagem
        if ( is_null($last) ) {
            return 'Aguardando Postagem';
        }

        //Postados
        if ( preg_match('/postado/i', $last['status']) ) {
            return 'Postados';
        }

        //Em Trânsito
        if ( preg_match('/trânsito|transito|fiscalização|recebido/i', $last['status'])) {
            return 'Em Trânsito';
        }

        //Saiu para Entrega
        if ( preg_match('/entrega/i', $last['status']) ) {
            return 'Saiu para Entrega';
        }

        //Retirada
        if ( preg_match('/retirada/i', $last['status']) ) {
            return 'Retirada';
        }

        //Entregue
        if ( preg_match('/entregue/i', $last['status']) ) {
            return 'Entregue';
        }

        //Devolvido
        if ( preg_match('/devolvido/i', $last['status']) ) {
            return 'Devolvido';
        }

    }

    public function store ($code)
    {
        return Tracking::create(
            array_merge($this->tracking($code),[
                'code' => $code
            ])
        );
    }

    public function update()
    {
        $trackings = Tracking::all();
        foreach ($trackings as $tracking) {
            $tracking->update($this->tracking($tracking->code));
        }
    }

}
