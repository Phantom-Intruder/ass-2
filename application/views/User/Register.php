<script id="registerForm" type="text/html">
    <form method="post" >
        <h3>Register</h3>

        <h5>Your Login data:</h5>
        <div data-fields="firstName,username,password,enterPasswordAgain"></div>

        <h5>About your new list:</h5>
        <div data-fields="listName,description"></div>

        <input type="submit" class="btn btn-info submit" />
    </form>
</script>

<script>
    $(function() {

        var UserWishList = Backbone.Model.extend({
            url: function(){
                var urlLink = "http://localhost/Wishlist/index.php/Home/register"
                return urlLink;
            },
            schema: {
                firstName: {
                    validators: ['required']
                },
                username: {
                    validators: ['required']
                },
                password: {
                    type: 'Password',
                    validators: ['required']
                },
                enterPasswordAgain: {
                    type: 'Password',
                    validators: [
                        'required',
                        { type: 'match', field: 'password', message: 'Passwords need to match!' }
                    ]
                },
                listName: {
                    validators: ['required']
                },
                description: {
                    validators: ['required']
                },
            },
            defaults: {
                firstName: '',
                username: '',
                password: '',
                enterPasswordAgain: '',
                listName: '',
                description: ''
            }
        });

        var userWishList = new UserWishList({});

        var RegisterForm = new Backbone.Form({
            model: userWishList,
            template: _.template($('#registerForm').html()),
        }).render();

        $('body').append(RegisterForm.el);

        //Run validation before submitting
        RegisterForm.on('submit', function(event) {
            var errs = RegisterForm.validate();

            if (errs){
                event.preventDefault();
            }
            else{
                event.preventDefault();

                var firstName = $("#c1_firstName").val();
                var username = $("#c1_username").val();
                var password = $("#c1_password").val();
                var listName = $("#c1_listName").val();
                var description = $("#c1_description").val();
                this.model.set({firstName: firstName, username: username, password: password, listName: listName, description: description});
                console.log(JSON.stringify(this.model));
                this.model.save();
            }
        });
    });
</script>