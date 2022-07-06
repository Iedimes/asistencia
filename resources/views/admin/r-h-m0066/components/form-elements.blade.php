<div class="form-group row align-items-center" :class="{'has-danger': errors.has('FuncNro'), 'has-success': fields.FuncNro && fields.FuncNro.valid }">
    <label for="FuncNro" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.r-h-m0066.columns.FuncNro') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.FuncNro" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('FuncNro'), 'form-control-success': fields.FuncNro && fields.FuncNro.valid}" id="FuncNro" name="FuncNro" placeholder="{{ trans('admin.r-h-m0066.columns.FuncNro') }}">
        <div v-if="errors.has('FuncNro')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('FuncNro') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('FuncNom'), 'has-success': fields.FuncNom && fields.FuncNom.valid }">
    <label for="FuncNom" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.r-h-m0066.columns.FuncNom') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.FuncNom" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('FuncNom'), 'form-control-success': fields.FuncNom && fields.FuncNom.valid}" id="FuncNom" name="FuncNom" placeholder="{{ trans('admin.r-h-m0066.columns.FuncNom') }}">
        <div v-if="errors.has('FuncNom')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('FuncNom') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('FUsuCod'), 'has-success': fields.FUsuCod && fields.FUsuCod.valid }">
    <label for="FUsuCod" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.r-h-m0066.columns.FUsuCod') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.FUsuCod" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('FUsuCod'), 'form-control-success': fields.FUsuCod && fields.FUsuCod.valid}" id="FUsuCod" name="FUsuCod" placeholder="{{ trans('admin.r-h-m0066.columns.FUsuCod') }}">
        <div v-if="errors.has('FUsuCod')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('FUsuCod') }}</div>
    </div>
</div>


