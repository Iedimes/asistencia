@extends('brackets/admin-ui::admin.layout.master')

@section('title', trans('brackets/admin-auth::admin.login.title'))

@section('styles')
<style>
    body.app {
        background-color: #f8fafc !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-card {
        border-radius: 16px !important;
        overflow: hidden;
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.15), 0 0 15px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid #e2e8f0 !important;
    }
    .auth-header-custom {
        background: linear-gradient(90deg, #1e3a8a 0%, #0f172a 100%);
        padding: 2.25rem 2rem 1.75rem;
        border-bottom: 1px solid #1e40af;
    }
    .form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
    }
    .btn-dark-pill {
        background: linear-gradient(90deg, #1e3a8a 0%, #0f172a 100%) !important;
        border: 1px solid #1e40af !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 50rem !important;
        transition: all 0.3s ease !important;
    }
    .btn-dark-pill:hover {
        background: linear-gradient(90deg, #1d4ed8 0%, #1e3a8a 100%) !important;
        box-shadow: 0 4px 14px rgba(30, 58, 138, 0.35) !important;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')
<div class="container my-auto py-5" id="app">
    <div class="row align-items-center justify-content-center auth">
        <div class="col-md-7 col-lg-5">
            <div class="card auth-card border-0">
                <div class="auth-header-custom text-center">
                    <div class="mb-3">
                        <span class="d-inline-block px-3 py-2 bg-white rounded-pill shadow-sm">
                            <img src="{{ asset('images/logo-muvh.jpg') }}" 
                                 alt="MUVH" 
                                 style="max-height: 52px; width: auto; object-fit: contain;" 
                                 onerror="this.onerror=null; this.src='{{ asset('images/logo.jpg') }}';" />
                        </span>
                    </div>
                    <h2 class="text-white font-weight-bold mb-1" style="font-size: 1.4rem; letter-spacing: -0.3px;">
                        {{ trans('brackets/admin-auth::admin.login.title') }}
                    </h2>
                    <p class="mb-0" style="color: #94a3b8; font-size: 0.92rem;">
                        {{ trans('brackets/admin-auth::admin.login.sign_in_text') }}
                    </p>
                </div>
                <div class="card-body p-4 p-md-5 bg-white">
                    <auth-form
                        :action="'{{ url('/admin/login') }}'"
                        :data="{}"
                        inline-template>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}" novalidate>
                            {{ csrf_field() }}
                            
                            @include('brackets/admin-auth::admin.auth.includes.messages')
                            
                            <div class="form-group mb-4" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
                                <label for="email" class="font-weight-600 text-dark" style="font-size: 0.88rem;">
                                    {{ trans('brackets/admin-auth::admin.auth_global.email') }}
                                </label>
                                <div class="input-group input-group--custom">
                                    <div class="input-group-addon bg-light border-right-0">
                                        <i class="input-icon input-icon--mail text-muted"></i>
                                    </div>
                                    <input type="text" v-model="form.email" v-validate="'required|email'" class="form-control py-2" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('brackets/admin-auth::admin.auth_global.email') }}">
                                </div>
                                <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
                            </div>

                            <div class="form-group mb-4" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
                                <label for="password" class="font-weight-600 text-dark" style="font-size: 0.88rem;">
                                    {{ trans('brackets/admin-auth::admin.auth_global.password') }}
                                </label>
                                <div class="input-group input-group--custom">
                                    <div class="input-group-addon bg-light border-right-0">
                                        <i class="input-icon input-icon--lock text-muted"></i>
                                    </div>
                                    <input type="password" v-model="form.password" class="form-control py-2" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('brackets/admin-auth::admin.auth_global.password') }}">
                                </div>
                                <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
                            </div>

                            <div class="form-group mt-4 mb-2">
                                <input type="hidden" name="remember" value="1">
                                <button type="submit" class="btn btn-dark-pill btn-block py-2.5 shadow-sm" :disabled="submiting">
                                    <i class="fa" :class="submiting ? 'fa-spinner fa-spin' : 'fa-sign-in me-1'"></i> 
                                    {{ trans('brackets/admin-auth::admin.login.button') }}
                                </button>
                            </div>
                        </form>
                    </auth-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom-scripts')
<script type="text/javascript">
    // fix chrome password autofill
    document.getElementById('password').dispatchEvent(new Event('input'));
</script>
@endsection
