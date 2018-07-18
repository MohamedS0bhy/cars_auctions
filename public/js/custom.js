let url = '/carsAuctions/public/';
let api_url = 'http://127.0.0.1:8000/api/';//will store api url 

// will get data from login form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#loginForm").click(function(){
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();

    $.ajax({
        type : 'POST',
        url : api_url + 'login',
        data : {
            'email' : email,
            'password' : password
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result.token);
            $.cookie("token", data.result.token, {expires: 1, path: '/'});

            // localStorage.userRole=data.result.user.role;
            // localStorage.userId=data.result.user.id;
            window.location = url + 'login';
        }
        else{

            $('#dangerMessage').show().text(data.result);
        }
            
    }).fail(function(data){
        console.log('fail');
        console.log(data);
        $('#dangerMessage').show().text(data.statusText);
    });
    
});

// will get data from register form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#registerForm").click(function(){
    let x = $('form#registerForm').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});

    console.log(x);

    if(x.password != x.confirmPass)
        $('#dangerMessage').show().text('password doesn\'t match ');
    else{
        $.ajax({
            type : 'POST',
            url : api_url + 'register',
            data : {
                'username' : x.username,
                'email' : x.email,
                'password' : x.password
            },
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            console.log(data);
            if(data.success){

                $('#successMessage').show().text("User registered successfully !");
                
                console.log(data.result.token);
                $.cookie("token", data.result.token, {expires: 1, path: '/'});
                window.location = url + 'login';
            }
            else
                $('#dangerMessage').show().text(data.message);
        }).fail(function(data){
            console.log('fail');
            console.log(data);
            $('#dangerMessage').show().text(data.statusText);
        });
        
    }
});

// logout function will send request with token 
// and make token invalid in return
// and redirect to login page
function logout(){
    $.ajax({
        type : 'POST',
        url : api_url + 'logout',
        data : {
            'token' : $.cookie('token')
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result);
            $.removeCookie('token', { path: '/' });
            window.location = url + 'login';
        }else
            alert(data.result);
        
    }).fail(function(data){
        console.log('fail');
        console.log(data);

    });
}