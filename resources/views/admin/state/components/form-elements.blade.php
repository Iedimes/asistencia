<div class="p-3 mb-2 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
    <div class="form-group mb-0" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
        <label for="name" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
            {{ trans('admin.state.columns.name') }} <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                <i class="fa fa-line-chart text-primary"></i>
            </span>
            <input type="text" v-model="form.name" v-validate="'required'" @input="form.name = $event.target.value.toUpperCase(); validate($event)" class="form-control rounded-end-pill text-dark font-weight-bold px-3" :class="{'is-invalid': errors.has('name'), 'is-valid': fields.name && fields.name.valid}" id="name" name="name" placeholder="NOMBRE DEL ESTADO..." style="border: 1px solid #cbd5e1; height: 44px; text-transform: uppercase;">
        </div>
        <div v-if="errors.has('name')" class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;" v-cloak>
            <i class="fa fa-exclamation-circle me-1"></i>@{{ errors.first('name') }}
        </div>
    </div>
</div>
