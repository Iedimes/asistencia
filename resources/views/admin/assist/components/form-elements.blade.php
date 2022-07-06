<div class="form-group row align-items-center" :class="{'has-danger': errors.has('heritage'), 'has-success': fields.heritage && fields.heritage.valid }">
    <label for="heritage" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.heritage') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.heritage" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('heritage'), 'form-control-success': fields.heritage && fields.heritage.valid}" id="heritage" name="heritage" placeholder="{{ trans('admin.assist.columns.heritage') }}">
        <div v-if="errors.has('heritage')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('heritage') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_user'), 'has-success': fields.id_user && fields.id_user.valid }">
    <label for="id_user" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.id_user') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_user" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_user'), 'form-control-success': fields.id_user && fields.id_user.valid}" id="id_user" name="id_user" placeholder="{{ trans('admin.assist.columns.id_user') }}">
        <div v-if="errors.has('id_user')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_user') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_state'), 'has-success': fields.id_state && fields.id_state.valid }">
    <label for="id_state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.id_state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
            v-model="form.state"
            :options="state"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.assist.columns.id_state') }}">
        </multiselect>
        <div v-if="errors.has('id_state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_state') }}</div>
    </div>
</div>


<!--
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_category'), 'has-success': fields.id_category && fields.id_category.valid }">
    <label for="id_category" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.id_category') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_category" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_category'), 'form-control-success': fields.id_category && fields.id_category.valid}" id="id_category" name="id_category" placeholder="{{ trans('admin.assist.columns.id_category') }}">
        <div v-if="errors.has('id_category')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_category') }}</div>
    </div>
</div>-->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_state'), 'has-success': fields.id_state && fields.id_state.valid }">
    <label for="id_state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.assist.columns.id_state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
            v-model="form.id_category"
            :options="state"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.assist.columns.id_state') }}">
        </multiselect>
        <div v-if="errors.has('id_state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_state') }}</div>
    </div>
</div>

