<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark">{{ trans('admin.detail-help.columns.user_id') }}</label>
    <div class="col-md-8">
        <multiselect
            class="text-dark font-weight-bold"
            v-model="form.user"
            :options="user"
            :multiple="false"
            track-by="id"
            label="full_name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.detail-help.columns.user_id') }}">
        </multiselect>
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('state_id'), 'has-success': fields.state_id && fields.state_id.valid }">
    <label for="state_id" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark">{{ trans('admin.detail-help.columns.state_id') }}</label>
    <div class="col-md-8">
        <multiselect
            class="text-dark font-weight-bold"
            v-model="form.state"
            :options="state"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.detail-help.columns.state_id') }}">
        </multiselect>
        <div v-if="errors.has('state_id')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('state_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-start mb-3" :class="{'has-danger': errors.has('solution'), 'has-success': fields.solution && fields.solution.valid }">
    <label for="solution" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark pt-2">{{ trans('admin.detail-help.columns.solution') }}</label>
    <div class="col-md-8">
        <textarea
            v-model="form.solution"
            @input="handleInput"
            rows="4"
            class="form-control text-dark font-weight-bold rounded-3 shadow-sm"
            style="border: 1px solid #cbd5e1;"
            :class="{'form-control-danger': errors.has('solution'), 'form-control-success': fields.solution && fields.solution.valid}"
            id="solution"
            name="solution"
            placeholder="{{ trans('admin.detail-help.columns.solution') }}">
        </textarea>
        <div v-if="errors.has('solution')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('solution') }}</div>
    </div>
</div>

<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark">{{ trans('admin.detail-help.columns.date') }}</label>
    <div class="col-md-8">
        <div class="input-group input-group--custom">
            <div class="input-group-addon bg-light border-end-0 px-3 d-flex align-items-center rounded-start-3" style="border: 1px solid #cbd5e1;"><i class="fa fa-calendar text-primary"></i></div>
            <datetime
                v-model="form.date"
                :config="datePickerConfig"
                class="flatpickr text-dark font-weight-bold"
                :class="{
                    'form-control-danger': errors.has('date'),
                    'form-control-success': fields.date && fields.date.valid
                }"
                id="date"
                name="date"
                placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}">
            </datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('category_id'), 'has-success': fields.category_id && fields.category_id.valid }">
    <label for="category_id" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark">{{ trans('admin.detail-help.columns.category_id') }}</label>
    <div class="col-md-8">
        <multiselect
            class="text-dark font-weight-bold"
            v-model="form.category"
            :options="category"
            :multiple="false"
            track-by="id"
            label="name"
            :taggable="true"
            tag-placeholder=""
            placeholder="{{ trans('admin.detail-help.columns.category_id') }}">
        </multiselect>
        <div v-if="errors.has('category_id')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('category_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center mb-3" :class="{'has-danger': errors.has('patrimony'), 'has-success': fields.patrimony && fields.patrimony.valid }">
    <label for="patrimony" class="col-md-3 col-form-label text-md-end font-weight-bold text-dark">{{ trans('admin.detail-help.columns.patrimony') }}</label>
    <div class="col-md-8">
        <input type="text" v-model="form.patrimony" @input="validate($event)" class="form-control text-dark font-weight-bold rounded-3 shadow-sm px-3" style="border: 1px solid #cbd5e1; height: 44px;" :class="{'form-control-danger': errors.has('patrimony'), 'form-control-success': fields.patrimony && fields.patrimony.valid}" id="patrimony" name="patrimony" placeholder="{{ trans('admin.detail-help.columns.patrimony') }}">
        <div v-if="errors.has('patrimony')" class="form-control-feedback form-text text-danger mt-1" v-cloak>@{{ errors.first('patrimony') }}</div>
    </div>
</div>


