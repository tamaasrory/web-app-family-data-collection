<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->has('q')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://mfdonline.bps.go.id/index.php?link=hasil_pencarian');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "pilihcari=desa&kata_kunci=" . $request->input('q') . "&submit=Cari");
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Cache-Control: max-age=0';
            $headers[] = 'Upgrade-Insecure-Requests: 1';
            $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36 OPR/68.0.3618.125';
            $headers[] = 'Origin: https://mfdonline.bps.go.id';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'Sec-Fetch-Site: same-origin';
            $headers[] = 'Sec-Fetch-Mode: navigate';
            $headers[] = 'Sec-Fetch-User: ?1';
            $headers[] = 'Sec-Fetch-Dest: document';
            $headers[] = 'Referer: https://mfdonline.bps.go.id/index.php?link=hasil_pencarian';
            $headers[] = 'Accept-Language: en-US,en;q=0.9';
            $headers[] = 'Cookie: PHPSESSID=e32vm2asgfc5nq9opg60m1h2o0; anova2=GA1.3.1513844776.1590807657; anova2_gid=GA1.3.1566952200.1590807657';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                return [
                    'value' => [],
                    'msg' => 'Error:' . curl_error($ch),
                ];
            } else {
                error_reporting(0);
                curl_close($ch);
                $dom = new DOMDocument;
                $dom->loadHTML($result);
                $xpath = new DOMXPath($dom);
                $result = [];
                foreach ($xpath->query("//table/tr[@class='table_content']") as $tr) {
                    $tmp = ['no', 'id_prov', 'prov', 'id_kab', 'kab', 'id_kec', 'kec', 'id_des', 'desa']; // reset the temporary array so previous entries are removed
                    $result2 = [];
                    foreach ($xpath->query("td", $tr) as $key => $td) {
                        $result2[$tmp[$key]] = ucwords(strtolower(trim($td->nodeValue)));
                    }
                    $result2['uniq'] = $result2['id_prov'] . $result2['id_kab'] . $result2['id_kec'] . $result2['id_des'];
                    $result[] = [
                        'text' => "Desa {$result2['desa']}, Kec. {$result2['kec']}, {$result2['kab']}, {$result2['prov']}",
                        'value' => $result2
                    ];
                }

                if (count($result)) {
                    return [
                        'value' => $result,
                        'msg' => 'data ditemukan',
                    ];
                }
            }
        }

        return [
            'value' => [],
            'msg' => 'data tidak ditemukan',
        ];
    }
}
