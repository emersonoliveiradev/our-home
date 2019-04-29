<?php


namespace BaseBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ApiTesteExcluir
 * @package BaseBundle\Controller
 * @Route("/api")
 */
class ApiTesteExcluir extends Controller {

    // Verificar pelo id que tipo de dispositivo eu devo manipular
    // O tipo do dispositivo não é o dispositivo
    const pinos = array(
        1=>'Rele',
        2=>'Lâmpada',
        3=>'Portao',
        4=>'Temperatura',
    );

    // Isso será excluído
    private static $aux = true;

    public function getRele($pin){
        # Obter o estado do pino $pin
        return self::$aux;
    }

    public function setRele($pin, $val){
        # Settar o valor do rele com o valor do $pin
        self::$aux = $val;
    }

    public function switchRele($pin){
        # Settar valor do rele como o inverso do valor atual
        if (($this->getRele($pin)) == true)
            $this->setRele($pin, false);
        else
            $this->setRele($pin, true);
    }


    /**
     * @Route("/{id}/switch")
     */
    public function switchAction($id, Request $request){
        $deviceName = self::pinos[$id];
        if ($deviceName == "Rele") {
           $this->switchRele($id);
        } elseif ($deviceName == "Portão") {
            //Fazer outra coisa
        }

        $data = [
            'data' => [
                'device' => $id,
                'device-type' => self::pinos[$id],
                'device-status-now' => $this->getRele($id),
            ],
        ];

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://127.0.0.1:8000');
        #$response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }


    /**
     * @Route("/{id}/get")
     */
    public function getAction($id, Request $request){
        //Retorná o status atual do dispositivo
        $deviceName = self::pinos[$id];
        if ($deviceName == "Rele"){
            $this->switchRele($id);
        }

        $data = [
            'data' => [
                'device' => $id,
                'device-type' => self::pinos[$id],
                'device-status-now' => $this->getRele($id),
            ],
        ];

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://127.0.0.1:8000');
        #$response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}

#$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
#echo json_encode($arr);
#return json_encode($arr);
#return new JsonResponse(['msg' => 'Serie Symfony 3.4 API',['segunda' => 'camada']]);
#curl -H "Authorization: {String}" -H "Content-Type: application/json;charset=UTF-8" https://site-alvo.com

/*
public function apiAction($id, Request $request)
{
    $client = new \GuzzleHttp\Client();
    $http = $this->getParameter('uri_api_reaspberry');
    $response = $client->request('GET', "{$http}/{$id}/state");

    $response->getBody();
    $dec = json_decode($response->getBody(), false);
    dump($dec->User);
    $ab = json_encode($dec->User->Nome);
    #echo($ab);

    $resp = json_decode($response->getBody(), true);
    if(isset($resp['User'])){
        echo("Foi");
    }


    return new Response(null);
}

*/

#echo(gettype($response->getBody()));
#$dec = json_decode($response->getBody(), false);
#echo(gettype($dec->User->Nome));
/*

