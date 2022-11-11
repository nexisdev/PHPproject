<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Web3;
use Web3p\EthereumTx\Transaction as EthereumTxTransaction;

class ContractHelper
{
    const chainId = 97;
    const fromAccount = '0x14b02E90305Cb16493475cb764194CCDA163c46C';
    const fromAccountPrivateKey = '25ac1f44ed3e366b28a53c8467dcf5a576901f50b24abfbf7df9b4eba6d54cbd';
    const factorToMultiplyGasEstimate = 500000;
    const secondsToWaitForReceipt = 300;

    public static function send($contractAddress, $abi, $functionName)
    {
        // get rest of arguments
        $arguments = func_get_args();
        $arguments = array_slice($arguments, 3);

        $web3 = new Web3(new HttpProvider(new HttpRequestManager('https://data-seed-prebsc-1-s1.binance.org:8545', 10)));
        $eth = $web3->eth;

        $contract = new Contract($web3->getProvider(), $abi);

        $rawTransactionData = '0x' . $contract
            ->at($contractAddress)
            ->getData($functionName, ...$arguments);

        $transactionParams = [
            'nonce' => "0x" . dechex(self::getTransactionCount($eth, self::fromAccount)?->toString()),
            'from' => self::fromAccount,
            'to' =>  $contractAddress,
            'gas' =>  '0x' . dechex(800000),
            'value' => '0x0',
            'data' => $rawTransactionData
        ];

        $gasPriceMultiplied = hexdec(dechex(self::getEstamtedGas($eth, $transactionParams)?->toString())) * self::factorToMultiplyGasEstimate;

        $transactionParams['gasPrice'] = '0x' . dechex($gasPriceMultiplied);
        $transactionParams['chainId'] = self::chainId;

        return self::sendTransactionWithSigning($eth, $transactionParams);
    }

    public static function getTransactionCount($eth, $fromAccount): ?object
    {
        $transactionCount = null;
        $eth->getTransactionCount($fromAccount, function ($err, $transactionCountResult) use(&$transactionCount) {
            if($err) {
                throw new \Exception('getTransactionCount error: ' . $err->getMessage());
            } else {
                $transactionCount = $transactionCountResult;
            }
        });

        return $transactionCount;
    }

    public static function getEstamtedGas($eth, $transactionParams): ?object
    {
        $estimatedGas = null;
        $eth->estimateGas($transactionParams, function ($err, $gas) use (&$estimatedGas) {
            if ($err) {
                throw new \Exception('estimateGas error: ' . $err->getMessage());
            } else {
                $estimatedGas = $gas;
            }
        });
        return $estimatedGas;
    }

    public static function sendTransactionWithSigning($eth, $transactionParams): ?object
    {
        $tx = new EthereumTxTransaction($transactionParams);
        $signedTx = '0x' . $tx->sign(self::fromAccountPrivateKey);
        $txHash = null;
        $eth->sendRawTransaction($signedTx, function ($err, $txResult) use (&$txHash) {
            if($err) {
                throw new \Exception('transaction error: ' . $err->getMessage());
            } else {
                $txHash = $txResult;
            }
        });

        $txReceipt = null;
        for ($i=0; $i <= self::secondsToWaitForReceipt; $i++) {
            $eth->getTransactionReceipt($txHash, function ($err, $txReceiptResult) use(&$txReceipt) {
                if($err) {
                    throw new \Exception('getTransactionReceipt error: ' . $err->getMessage());
                } else {
                    $txReceipt = $txReceiptResult;
                }
            });

            if ($txReceipt) {
                break;
            }

            sleep(1);
        }

        return $txReceipt;
    }
}
