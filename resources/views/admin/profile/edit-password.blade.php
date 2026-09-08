@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.admin-user.actions.edit_password'))

@section('body')

    <div class="container-xl">

        <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

            <profile-edit-password-form
                :action="'{{ url('admin/password') }}'"
                :data="{{ $adminUser->toJson() }}"
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header font-weight-bold text-white d-flex align-items-center gap-2 py-3 px-4" style="background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%); border-bottom: 1px solid #334155; font-size: 1.05rem;">
                        <i class="fa fa-key text-warning" style="color: #f59e0b;"></i> {{ trans('admin.admin-user.actions.edit_password') }}
                    </div>

                    <div class="card-body py-4">

                        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
                            <label for="password" class="col-form-label text-md-right font-weight-600" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
                                <input type="password" v-model="form.password" v-validate="'required|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.admin-user.columns.password') }}" ref="password">
                                <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
                            <label for="password_confirmation" class="col-form-label text-md-right font-weight-600" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password_repeat') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
                                <input type="password" v-model="form.password_confirmation" v-validate="'required|confirmed:password|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.admin-user.columns.password') }}" data-vv-as="password">
                                <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
                            </div>
                        </div>
                        
                        
                    </div>

                    <div class="card-footer bg-light d-flex align-items-center gap-2 py-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-bold" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-save'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                        <a href="{{ url('admin/helps') }}" class="btn text-white rounded-pill px-4 font-weight-bold" style="background-color: #64748b; border: none;">
                            <i class="fa fa-ban me-1"></i> Cancelar
                        </a>
                    </div>

                </form>

            </profile-edit-password-form>

        </div>

    </div>

@endsection
