/**
 * Google2FA App
 */


var appId = 'vue-google2fa';

if (document.getElementById(appId)) {
    new Vue({
        el: '#'+appId,

        data: {
            company: 'Acme Inc.',
            email: '',
            secretKey: '',
            secretKeyPrefix: '',
            secretKeyPrefixB32: '',
            qrCodeUrl: '',
            password: '',
            passwordList: [],
            window: 4,
            currentTimestamp: 0,
            error: '',
            busy: false,
        },

        methods: {
            __requestEmail() {
                axios
                    .get(Laravel.apiPrefix+'/google2fa/email')
                    .then(response => this.email = response.data.email);
            },

            __requestCompany() {
                axios
                    .get(Laravel.apiPrefix+'/google2fa/company')
                    .then(response => this.company = response.data.company);
            },

            __requestSecretKey() {
                this.error = null;

                axios
                    .get(Laravel.apiPrefix+'/google2fa/secret-key/'+this.secretKeyPrefix)
                    .then(response => {
                        if (response.data.message) {
                            return this.error = response.data.message;
                        }

                        this.secretKey = response.data.secretKey;
                    })
                    .catch(error => this.error = error.response.data.message)
                ;
            },

            __requestSecretKeyPrefix() {
                axios
                    .get(Laravel.apiPrefix+'/google2fa/secret-key-prefix')
                    .then(response => {
                        this.secretKeyPrefix = response.data.secretKeyPrefix;

                        this.secretKeyPrefixB32 = response.data.secretKeyPrefixB32;
                    })
                ;
            },

            __getQRCodeUrl: function () {
                if (! this.company || ! this.email || ! this.secretKey) {
                    return;
                }

                axios
                    .get(Laravel.apiPrefix+'/google2fa/qr-code-url/'+this.company+'/'+this.email+'/'+this.secretKey)
                    .then(response => this.qrCodeUrl = response.data.url)
                ;
            },

            __passwordIsValid(element) {
                console.log(element);
                return element.isValid == true;
            },

            __anyPasswordIsValid() {
                if (this.passwordList.length == 0) {
                    return false;
                }

                return typeof this.passwordList.find(this.__passwordIsValid) !== 'undefined';
            },

            addToPasswordList: function (password) {
                this.passwordList[password] = { password: password, isValid: true };
            },

            __checkPassword() {
                setTimeout(this.__checkPassword, 3000);

                if (this.busy) {
                    return;
                }

                var data = this.$data;

                data['csrf_token'] = Laravel.csrfToken;

                this.busy = true;

                axios
                    .post(Laravel.apiPrefix+'/google2fa/check-password', data)
                    .then(response => {
                        this.passwordList = response.data.passwordList;

                        this.currentTimestamp = response.data.currentTimestamp;

                        this.busy = false;
                    })
                    .catch(error => this.busy = false)
                ;
            },

            __validatePassword() {
                return this.password.length == 6;
            },

            __clearList() {
                this.passwordList = [];
            }
        },

        mounted() {
            this.__requestEmail();

            this.__requestCompany();

            this.__requestSecretKeyPrefix();

            this.__checkPassword();
        },

        computed: {
            passwordIsValid() {
                if (! this.__validatePassword()) {
                    return false;
                }

                password = this.passwordList.find(item => {
                    return item.password == this.password;
                })

                if (typeof password !== 'undefined') {
                    return password.isValid;
                }

                return false;
            }
        },

        watch: {
            secretKeyPrefix: function () {
                this.__requestSecretKey();
            },

            secretKey: function() {
                this.__getQRCodeUrl();
            },

            password: function() {
                if (this.__validatePassword()) {
                    this.__checkPassword();
                }
            },

            window: function() {
                this.__checkPassword();
            },

            email: function() {
                this.__getQRCodeUrl();
            },

            company: function() {
                this.__getQRCodeUrl();
            },
        }
    });
}
