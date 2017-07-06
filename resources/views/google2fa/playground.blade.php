@extends('templates.main')

@section('content')
    <div id="vue-google2fa">
        <h1><a href="https://github.com/antonioribeiro/google2fa">Google2FA Package</a></h1>
        <p class="large">Playground</p>
        <a href="/google2fa/middleware" class="btn btn-success" target="_blank">Test middleware</a>
        <br><br>

        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company</label>
                        <input v-model="company" type="company" class="form-control" placeholder="Company">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email address</label>
                        <input v-model="email" type="email" class="form-control" placeholder="Email">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Secret Key Prefix (@{{ secretKeyPrefix.length }} bytes)</label>
                        <input v-model="secretKeyPrefix" type="text" class="form-control" placeholder="Prefix">
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Secret Key Prefix - Base 32 (@{{ secretKeyPrefixB32.length }} bytes)</label>
                        <input v-model="secretKeyPrefixB32" type="text" class="form-control" placeholder="Prefix">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Secret Key (@{{ secretKey.length }} bytes)</label>
                <input v-model="secretKey" type="text" class="form-control" readonly>
                <span v-if="error" class="text-danger">@{{ error }}</span>
            </div>

            <div class="form-group">
                <label>QRCode URL</label>
                <input v-model="qrCodeUrl" type="text" class="form-control" readonly>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-xs-12">
                            <label>QR Code</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <img :src="qrCodeUrl" alt="">
                        </div>
                        <div class="col-xs-12">
                            <p></p>
                            <p>current password</p>
                            <h4 class="btn-success" style="padding: 20px;">
                                @{{ currentPassword.password }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type Password</label>
                                <div class="input-group">
                                    <input v-model="password" type="text" class="form-control">

                                    <div class="input-group-addon" v-if="password">
                                        <i class="fa fa-check text-success" v-if="passwordIsValid"></i>
                                        <i class="fa fa-times text-danger" v-if="! passwordIsValid"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Window</label>
                                <input v-model="window" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>&nbsp</label>
                            <div @click="__clearList()" class="btn btn-danger btn-block">
                                <i class="fa fa-trash-o"></i> Clear
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="passwordList.length > 0">
                        <div class="col-xs-12">
                            <table class="table table-striped">
                                <thead>
                                    <th>
                                        <div v-if="passwordIsValid || __anyPasswordIsValid()">
                                            <i class="fa fa-refresh fa-spin fa-fw"></i>
                                        </div>

                                        <div v-if="! passwordIsValid && ! __anyPasswordIsValid()">
                                            #
                                        </div>
                                    </th>

                                    <th>Password</th>
                                    <th>Valid?</th>
                                    <th>validation ts</th>
                                    <th>current ts</th>
                                    <th>Newer than last?</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, key) in passwordList">
                                        <td>@{{ key+1 }}</td>
                                        <td style="text-align: left !important;">@{{ item.password }}</td>
                                        <td>
                                            <i class="fa fa-check text-success" v-if="item.isValid"></i>
                                            <i class="fa fa-times text-danger" v-if="! item.isValid"></i>
                                        </td>
                                        <td style="text-align: left !important;">@{{ item.timestamp }}</td>
                                        <td style="text-align: left !important;">@{{ currentTimestamp }}</td>
                                        <td>
                                            <i class="fa fa-check text-success" v-if="item.isValidAfterTimestamp"></i>
                                            <i class="fa fa-times text-danger" v-if="! item.isValidAfterTimestamp"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
