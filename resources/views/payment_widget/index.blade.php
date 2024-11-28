<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
    <title>Document</title>
</head>
<body>
<script>
    let language  = "ru-RU";
    let summa     = {{ $summa }};
    let client_id = {{ $client_id }};
    var hostname  = location.hostname;
    var port      = location.port;
    var protocol  = location.protocol;
    var fullHost  = `${protocol}//${hostname}:${port}`;
    console.log(fullHost);

    function pay() {
        var widget = new cp.CloudPayments({
            language: language
        })
        widget.pay('auth', // или 'charge'
            { //options
                publicId   : 'pk_c5f165beb1b07305dd839b2fc0d81', //id из личного кабинета
                description: 'Оплата товаров в refresh-software.ru', //назначение
                amount     : summa, //сумма
                currency   : 'RUB', //валюта
                accountId  : 'user@example.com', //идентификатор плательщика (необязательно)
                invoiceId  : '1234567', //номер заказа  (необязательно)
                skin       : "mini", //дизайн виджета (необязательно)
                autoClose  : 3
            }, {
                onSuccess : function (options) { // success
                    var myHeaders = new Headers();
                    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                    var urlencoded = new URLSearchParams();
                    urlencoded.append("client_id", client_id);
                    urlencoded.append("summa", summa);

                    var requestOptions = {
                        method  : 'POST',
                        headers : myHeaders,
                        body    : urlencoded,
                        redirect: 'follow'
                    };

                    fetch(`${fullHost}/api/client/add_amount`, requestOptions)
                        .then(response => response.text())
                        .then(result => {
                            console.log('успех');
                            window.location.href = '/';
                        })
                        .catch(error => console.log('error', error));

                },
                onFail    : function (reason, options) { // fail
                    //действие при неуспешной оплате
                },
                onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
                    //например вызов вашей аналитики Facebook Pixel
                }
            }
        )
    }

    pay();
</script>
</body>
</html>


