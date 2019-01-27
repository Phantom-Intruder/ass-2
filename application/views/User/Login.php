<?php
    if($directed) {
        echo '<div class="alert alert-error">Please login using valid credentials</div>';
    }
    ?>
<script id="loginForm" type="text/html">
    <form style="margin-left: 50px" method="post">
        <h3>Login</h3>

        <h5>Your Login details:</h5>
        <div data-fields="username,password"></div>

        <input type="submit" class="btn btn-info submit" />
    </form>
</script>

<script>
    $(function() {

        var LoginModel = Backbone.Model.extend({
            url: function(){
                var urlLink = "<?= base_url().'/index.php/Home/login'; ?>"
                return urlLink;
            },
            schema: {
                username: {
                    validators: ['required']
                },
                password: {
                    type: 'Password',
                    validators: ['required']
                },
            },
            defaults: {
                username: '',
                password: ''
            }
        });

        var loginModel = new LoginModel({});

        var LoginForm = new Backbone.Form({
            model: loginModel,
            template: _.template($('#loginForm').html()),
        }).render();

        $('body').append(LoginForm.el);

        //Run validation before submitting
        LoginForm.on('submit', function(event) {
            var errs = LoginForm.validate();

            if (errs){
                event.preventDefault();
            }
            else{
                event.preventDefault();
                var username = $("#c1_username").val();
                var password = $("#c1_password").val();
                this.model.set({username: username, password: password});
                this.model.save();
                window.location = "<?= base_url().'/index.php/Home/List'; ?>"
            }
        });

    });
</script>