{{-- <div class="form-group row align-items-center" :class="{'has-danger': errors.has('help_id'), 'has-success': fields.help_id && fields.help_id.valid }">
    <label for="help_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.help_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.help_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('help_id'), 'form-control-success': fields.help_id && fields.help_id.valid}" id="help_id" name="help_id" placeholder="{{ trans('admin.detail-help.columns.help_id') }}">
        <div v-if="errors.has('help_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('help_id') }}</div>
    </div>
</div> --}}

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{-- <input type="text" v-model="form.user_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.detail-help.columns.user_id') }}"> --}}
        <multiselect
        v-model="form.user"
        :options="user"
        :multiple="false"
        track-by="id"
        label="full_name"
        :taggable="true"
        tag-placeholder=""
        placeholder="{{ trans('admin.detail-help.columns.user_id') }}">
    </multiselect>
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('state_id'), 'has-success': fields.state_id && fields.state_id.valid }">
    <label for="state_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.state_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
            v-model="form.state"
            :options="state"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.detail-help.columns.state_id') }}">
        </multiselect>
        <div v-if="errors.has('state_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('solution'), 'has-success': fields.solution && fields.solution.valid }">
    <label for="solution" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.solution') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea v-model="form.solution"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('solution'), 'form-control-success': fields.solution && fields.solution.valid}" id="solution" name="solution" placeholder="{{ trans('admin.detail-help.columns.solution') }}"></textarea>
        <div v-if="errors.has('solution')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('solution') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig"  class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('category_id'), 'has-success': fields.category_id && fields.category_id.valid }">
    <label for="category_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.category_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{-- <input type="text" v-model="form.category_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('category_id'), 'form-control-success': fields.category_id && fields.category_id.valid}" id="category_id" name="category_id" placeholder="{{ trans('admin.detail-help.columns.category_id') }}"> --}}
        <multiselect
            v-model="form.category"
            :options="category"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.detail-help.columns.category_id') }}">
        </multiselect>
        <div v-if="errors.has('category_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('category_id') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('patrimony'), 'has-success': fields.patrimony && fields.patrimony.valid }">
    <label for="help_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.detail-help.columns.patrimony') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.patrimony"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('patrimony'), 'form-control-success': fields.patrimony && fields.patrimony.valid}" id="patrimony" name="patrimony" placeholder="{{ trans('admin.detail-help.columns.patrimony') }}">
        <div v-if="errors.has('patrimony')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('patrimony') }}</div>
    </div>
</div>

