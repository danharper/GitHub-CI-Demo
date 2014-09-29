<?php namespace Deployer\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GitHubWebhookController {

	public function __invoke(Application $app, Request $request)
	{
		$event = $request->headers->get('X-Github-Event');

		$signature = $request->headers->get('X-Hub-Signature');

		$payload = $request->getContent();

		if ( ! $payload)
		{
			return new JsonResponse(['msg' => 'No Payload'], 500);
		}

		if ( ! $this->validateSignature($payload, $signature))
		{
			return new JsonResponse(['msg' => 'Invalid Payload'], 500);
		}

		$payload = json_decode($payload);

		switch ($event)
		{
			case 'deployment':
				return $this->processDeployment($payload);
				break;
		}
	}

	/**
	 * @param $rawPayload
	 * @param $signature
	 * @return bool
	 */
	private function validateSignature($rawPayload, $signature)
	{
		$secret = 'foo';

		return hash_hmac('sha1', $rawPayload, $secret) === $signature;
	}

	/**
	 * @param $payload
	 * @return mixed
	 */
	private function processDeployment($payload)
	{
		return 'Deploy: '.$payload->sha.' to: '.$payload->environment;
	}

} 