<?php

namespace openecontmd\external_api\modules\external\controllers\v1;

use Yii;
use yii\rest\Controller;
use OpenApi\Annotations as OA;

use DateTime;
use Einvoicing\Invoice;
use Einvoicing\Presets;
use Einvoicing\Presets\Peppol;
use Einvoicing\Presets\CiusAtGov;
use Einvoicing\Presets\CiusRo;
use Einvoicing\Identifier;
use Einvoicing\Party;
use Einvoicing\InvoiceLine;
use Einvoicing\Writers\UblWriter;

use openecontmd\external_api\models\CredentialAPI;
use yii\web\HttpException;
use yii\web\BadRequestHttpException;

class CredentialsController extends Controller
{
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
		return true;
	}

/** Set External Credentials
 * @OA\Post(
 *     path="/external/v1/credentials/set-external-credentials",
 *     tags={"external"},
 *     @OA\Response(
 *         response="200",
 *         description="Set External Credentials",
 *     ),
 *     @OA\Parameter(
 *         name="client_name",
 *         in="query",
 *         description="Client Name",
 *         required=true,
 *         @OA\Schema(
 *             default="External Company",
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="user",
 *         in="query",
 *         description="User Token",
 *         required=true,
 *         @OA\Schema(
 *             default="4e0d1c3fa6be0b4d233f66aaee5e0b7c",
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="password",
 *         in="query",
 *         description="Access Token",
 *         required=true,
 *         @OA\Schema(
 *             default="759ef07b9f59b716bf21ee2bf48022bc",
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="acl",
 *         in="query",
 *         description="ACL",
 *         required=true,
 *         @OA\Schema(
 *             default="search,list,read,write,delete",
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="state",
 *         in="query",
 *         description="Client State",
 *         required=true,
 *         @OA\Schema(
 *             default="active",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetExternalCredentials()
	{
	    $client_name = Yii::$app->request->get('client_name');
	    $user = Yii::$app->request->get('user');
	    $password = Yii::$app->request->get('password');
	    $acl = Yii::$app->request->get('acl');
	    $state = Yii::$app->request->get('state');

	    $r = CredentialAPI::createCredential($client_name, $user, $password, $acl, $state);
	    if (!$r)
	        throw new BadRequestHttpException(json_encode(['code' => -2, 'message' => 'Bad operation!!'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

	    $response = [
	        'action' => 'set',
	        'result' => $r,
	        'state' => 'active',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Get External Credentials
 * @OA\Post(
 *     path="/external/v1/credentials/get-external-credentials",
 *     tags={"external"},
 *     @OA\Response(
 *         response="200",
 *         description="Get External Credentials",
 *     ),
 *     @OA\Parameter(
 *         name="user",
 *         in="query",
 *         description="User Token",
 *         required=true,
 *         @OA\Schema(
 *             default="4e0d1c3fa6be0b4d233f66aaee5e0b7c",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionGetExternalCredentials()
	{
	    $user = Yii::$app->request->get('user');
	    $r = CredentialAPI::getCredential($user);

	    if (!$r)
	       throw new BadRequestHttpException(json_encode(['code' => -1, 'message' => 'No such user!'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

	    $response = [
	        'action' => 'get',
	        'result' => $r,
	        'state' => 'active',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Get External Logs
 * @OA\Post(
 *     path="/external/v1/credentials/get-external-logs",
 *     tags={"external"},
 *     @OA\Response(
 *         response="200",
 *         description="Get External Logs",
 *     ),
 *     @OA\Parameter(
 *         name="value",
 *         in="query",
 *         description="number",
 *         required=true,
 *         @OA\Schema(
 *             default="QWERTY",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionGetExternalLogs()
	{
	    $response = [
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

}
