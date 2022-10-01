<?php

session_start();

$auth = $_SESSION['login'];

if(!$auth)
{
  header('Location: https://jasencio99.github.io/Pagina.github.io/');
}

?>
<?php
$location = "https://banguat.gob.gt/variables/ws/TipoCambio.asmx?WSDL";

$request= '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://www.banguat.gob.gt/variables/ws/">
   <soapenv:Header/>
   <soapenv:Body>
      <ws:TipoCambioDia/>
   </soapenv:Body>
</soapenv:Envelope>
';

///print("Resquest : <br>");
//print("<pre>".htmlentities($request)."</pre>");

$action = "TipoCambioDia";
$headers = [
    'Method: POST',
    'Connection: Keep-Alive',
    'User-Agent: Apache-HttpClient/4.5.5 (Java/16.0.1)',
    'Content-Type: text/xml;charset=UTF-8',
    'SOAPAction: http://www.banguat.gob.gt/variables/ws/TipoCambioDia',
];

//Segun Documentacion
$ch = curl_init($location);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

$response = curl_exec($ch);
$err_status = curl_errno($ch);

require_once 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

if( isset($_FILES['file'])){
    s3_upload_put_object($_FILES['file']);
}

function s3_upload_put_object($file){
    $options = [
        'region' => 'us-west-2',
        'version' => '2006-03-01',
        'credentials' => [
            'key' => 'AKIASEALAIVTSTKSHTFZ',
            'secret' => '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'
        ]
        ];
        $file_name = $file['name'];
        $file_path = $file['tmp_name'];
        try {
            $s3Client = new S3Client($options);
            $result = $s3Client->putObject([
                'Bucket' => 'umg-raul',
                'Key' => $file_name,
                'SourceFile' => $file_path,
            ]);
            echo "<pre>".print_r($result, true)."</pre>";
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }
}
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio</title>
    <style>
        .divfoto{
            background-image: linear-gradient(to left, #3D454D, #52677C);
            color: #fff
        }
        
    </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <h3 id="nUsuario" class = "text-white" style="color:write"><?php echo $_SESSION['usuario']?></h3>
         <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
    
        <li class="nav-item">
      <a class="nav-link" href="<?php $_SESSION = [];?>">Cerrar Sesión</a>
      <p class = "text-white"><?php echo $response?></p>
    </li>
            
        </ul>
    </div>
    
</nav>
<div class="divfoto">
<form action="" method="post"
    enctype="multipart/form-data">
    <label for="file">Seleccionar archivo</label>
    <input type="file" name="file" id="file">
    <button type="submit">Subir Archivo</button>
    </div>

</body>
</html>