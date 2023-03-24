<?php
use Omnipay\Omnipay;

class Payment
{
	public function gateway()
	{
		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername("oneoutlet@oneoutlet.site");
		$gateway->setPassword("ARySNgUCvyU9tEBp-zsd0WbbNO_7Nxxxxoi3xxxxh2cTuDxRh7xxxxVu9W5ZkIBGYqjqfzHrjY3wta");
		$gateway->setSignature("EOEwezsNWMWQM63xxxxxknr8QLoAOoC6lD_-kFqjgKxxxxxwGWIvsJO6vP3syd10xspKbx7LgurYNt9");
		$gateway->setTestMod(true);
		return $gateway;
	}

	public function purchase(array $parameters)
	{
		$response = $this->gateway()->purchase($parameters)->send();

		return $response;
	}

	public function complete(array $parameters)
	{
		$response = $this->gateway()->completePurchase($parameters)->send();
		return $response;
	}

	public function formatAmount($amount)
	{
		return number_format($amount, 2, '.', '');
	}

	public function getCancelUrl($order = "")
	{
		return $this->route("http://Oneoutlet.site/", $order);
	}

	public function getReturnUrl($order = "")
   {
       return $this->route('http://Oneoutlet.site/src/License', $order);
   }

   public function route($name, $params)
   {
       return $name;
   }
}