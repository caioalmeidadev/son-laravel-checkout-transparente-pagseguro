@extends('layouts.default')

@section('content')

<h2 class="header">Checkout</h2>

    <ul class="tabs tabs-fixed-width">
        <li class="tab"><a href="#step1">Suas Informações</a></li>
        <li class="tab"><a href="#step2">Entrega</a></li>
        <li class="tab"><a href="#step3">Pagamento</a></li>
    </ul>
<form action="/checkout/{{ $id }}" method="POST" id="form">
     {{ csrf_field() }}
     
     <input type="hidden" name="itemId1" value="0001">
     <input type="hidden" name="itemDescription1" value="Produto PagSeguro1">
     <input type="hidden" name="itemAmount1" value="250.00">
     <input type="hidden" name="itemQuantity1" value="2">

    <div id="step1">
        <p> Preencha suas informações</p>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="senderName" name="senderName" >
                <label for="senderName">Nome Completo</label>
            </div>
        </div>
        
        <div class="row">
            <div class="input-field col s6">
                <input type="text" id="senderCPF" name="senderCPF" >
                <label for="senderCPF">CPF</label>
            </div>
        
            <div class="input-field col s6">
                <input type="text" id="senderEmail" name="senderEmail" >
                <label for="senderEmail">Email</label>
            </div>
        </div>  
        
        <div class="row">
            <div class="input-field col s6 offset-s3">
                <input type="text" id="senderPhone" name="senderPhone" >
                <label for="senderPhone">Telefone</label>
            </div>
        </div>
    </div>
   
    <div id="step2">
        <p>Informe os dados para entrega</p>

        <div class="row">
            <div class="input-field col s6">
                <input type="text" id="shippingAddressPostalCode" name="shippingAddressPostalCode" >
                <label for="shippingAddressPostalCode">CEP</label>
            </div>
        
            <div class="input-field col s6">
                <input type="text" id="shippingAddressStreet" name="shippingAddressStreet" >
                <label for="shippingAddressStreet">Logradouro</label>
            </div>
        </div> 

        <div class="row">
            <div class="input-field col s6">
                <input type="text" id="shippingAddressNumber" name="shippingAddressNumber" >
                <label for="shippingAddressNumber">Número</label>
            </div>
        
            <div class="input-field col s6">
                <input type="text" id="shippingAddressComplement" name="shippingAddressComplement" >
                <label for="shippingAddressComplement">Complemento</label>
            </div>
        </div> 

        <div class="row">
            <div class="input-field col s6">
                <input type="text" id="shippingAddressDistrict" name="shippingAddressDistrict" >
                <label for="shippingAddressDistrict">Bairro</label>
            </div>
        
            <div class="input-field col s6">
                <input type="text" id="shippingAddressCity" name="shippingAddressCity" >
                <label for="shippingAddressCity">Cidade</label>
            </div>
        </div> 

        <div class="row">
            <div class="input-field col s6">
                <input type="text" id="shippingAddressState" name="shippingAddressState" >
                <label for="shippingAddressState">Estado</label>
            </div>
        
            <div class="col s6">
                <input type="hidden" name="shippingCost" value="21.50">
                <select name="shippingType" id="shippingType" class="browser-default">
                    <option disabled selected>Forma de Entrega</option>
                    <option value="1">Encomenda Normal (PAC)</option>
                    <option value="2">SEDEX</option>
                    <option value="3">Tipo de frente não especificado</option>
                </select>
                <label for="shippingType">Forma de Entrega</label>
            </div>
        </div> 
    </div>

    <div id="step3">
        <p>Preencha os dados para pagamento</p>
        <input type="hidden" name="creditCardToken" id="creditCardToken">
        <div class="row">
                <div class="input-field col s10">
                    <input type="text" id="cardNumber">
                    <label for="cardNumber">Número do Cartão</label>
                    <div id="card_brand"></div>
                </div>
            
                <div class="input-field col s2">
                    <input type="text" id="cvv">
                    <label for="cvv">CVV</label>
                </div>
        </div>

        <div class="row">
                <div class="input-field col s4">
                    <input type="text" id="expirationMonth">
                    <label for="expirationMonth">Mês de Expiração</label>
                </div>
            
                <div class="input-field col s4">
                    <input type="text" id="expirationYear" >
                    <label for="expirationYear">Ano de Expiração</label>
                </div>

                <div class="col s4">
                    <select id="installmentPayment" class="browser-default">
                        <option disabled selected>Parcelamento</option>
                    </select>
                    <label for="installmentPayment">Parcelamento</label>
                </div>
        </div> 




        <div class="row">
                <div class="input-field col s12">
                    <input type="submit" class="btn" value="Pagar">
                </div>
         </div>
    </div>
</form>


<div id="paymentMethods" class="center-align"></div>
@endsection


@section('script')

<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script src="/js/pagseguro.js"></script>
<script>
$(document).ready(function(){
    $('.tabs').tabs();
});

const paymentData = {
    brand   :   '',
    amount  :   {{ $amount }}
};
    PagSeguroDirectPayment.setSessionId('{!! $session !!}');
    pagSeguro.getPaymentMethods(paymentData.amount).then(function(urls){
        let html = '';
        
        urls.forEach(function(url){
           html += '<img src="' + url  +'" class="credit_card">' 
        });

        $('#paymentMethods').html(html);
    });

$('#shippingAddressPostalCode').on('keyup', function(){
    let cep = $(this).val();

    if (cep.length == 8){
        $.get('https://viacep.com.br/ws/' + cep + '/json/')
            .then(function(res){
                $('#shippingAddressDistrict').val(res.bairro);
                $('#shippingAddressCity').val(res.localidade);
                $('#shippingAddressStreet').val(res.logradouro);
                $('#shippingAddressState').val(res.uf);
                M.updateTextFields();
            })
            
    }
});

$('#cardNumber').on('keyup',function(){
  if($(this).val().length >= 6)
  {
      let bin = $(this).val();
      pagSeguro.getBrand(bin).then(function(res){
          
          paymentData.brand = res.result.brand.name;
          $('#card_brand').html('<img src="' + res.url + '" class="credit_card">');
      });
  }  
});

$('#form').on('submit',function(e){
    e.preventDefault();
    console.log(paymentData.brand);
    let params = {
        cardNumber : $('#cardNumber').val(),
        cvv : $('#cvv').val(),
        expirationMonth : $('#expirationMonth').val(),
        expirationYear : $('#expirationYear').val(),
        brand : paymentData.brand,
    };
    pagSeguro.createCardToken(params).then(function(token){
        $('#creditCardToken').val(token);
        let url = $('#form').attr('action'); 
        let data = $('#form').serialize();
        $.post(url, data)
    })
})
</script>
    
@endsection