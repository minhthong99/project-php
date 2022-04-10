paypal.Buttons({
    style :{
        color:'blue',
        shape:'pill'
    },
    createOrder: function(data, actions) {
        
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '100'

                }
            }]
        });
    },
    onApprove: function(data, actions) {       
        // Make a call to the REST api to execute the payment
        return actions.order.capture().then(function(details) {
            console.log(details);   
            alert('toán đơn hàng thành công');   
              
        });
    },
    onCancel: function(data) {
        alert('chưa thanh toán đơn hàng');
    }


}).render('#paypal-payment-button');