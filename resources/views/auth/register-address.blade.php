<!-- Address -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('address')}">
    <label class="col-md-4 control-label">Address</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address" lazy>

        <span class="help-block" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
        </span>
    </div>
</div>

<!-- Address Line 2 -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('address_line_2')}">
    <label class="col-md-4 control-label">Address Line 2</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address_line_2" lazy>

        <span class="help-block" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
        </span>
    </div>
</div>

<!-- City -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('city')}">
    <label class="col-md-4 control-label">City</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.city">

        <span class="help-block" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
        </span>
    </div>
</div>

<!-- State & ZIP Code -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('state')}">
    <label class="col-md-4 control-label">State & ZIP / Postal Code</label>

    <!-- State -->
    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="State" v-model.lazy="registerForm.state">

        <span class="help-block" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
    </div>

    <!-- Zip Code -->
    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="Postal Code" v-model.lazy="registerForm.zip">

        <span class="help-block" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
    </div>
</div>

<!-- Country -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('country')}">
    <label class="col-md-4 control-label">Country</label>

    <div class="col-sm-6">
        <select class="form-control" v-model.lazy="registerForm.country">
            @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                <option value="{{ $key }}">{{ $country }}</option>
            @endforeach
        </select>

        <span class="help-block" v-show="registerForm.errors.has('country')">
            @{{ registerForm.errors.get('country') }}
        </span>
    </div>
</div>

<!-- European VAT ID -->
<div class="form-group" :class="{'has-error': registerForm.errors.has('vat_id')}" v-if="countryCollectsVat">
    <label class="col-md-4 control-label">VAT ID</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.vat_id">

        <span class="help-block" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}
        </span>
    </div>
</div>
