<!-- Address -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="form.address" :class="{'is-invalid': form.errors.has('address')}">

        <span class="invalid-feedback" v-show="form.errors.has('address')">
            @{{ form.errors.get('address') }}
        </span>
    </div>
</div>

<!-- Address Line 2 -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address Line 2')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="form.address_line_2" :class="{'is-invalid': form.errors.has('address_line_2')}">

        <span class="invalid-feedback" v-show="form.errors.has('address_line_2')">
            @{{ form.errors.get('address_line_2') }}
        </span>
    </div>
</div>

<!-- City -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('City')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="form.city" :class="{'is-invalid': form.errors.has('city')}">

        <span class="invalid-feedback" v-show="form.errors.has('city')">
            @{{ form.errors.get('city') }}
        </span>
    </div>
</div>

<!-- State & ZIP Code -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('State & ZIP / Postal Code')}}</label>

    <!-- State -->
    <div class="col-sm-3">
        <input type="text" class="form-control" v-model="form.state" placeholder="{{__('State')}}" :class="{'is-invalid': form.errors.has('state')}">

        <span class="invalid-feedback" v-show="form.errors.has('state')">
            @{{ form.errors.get('state') }}
        </span>
    </div>

    <!-- Zip Code -->
    <div class="col-sm-3">
        <input type="text" class="form-control" v-model="form.zip" placeholder="{{__('Postal Code')}}">

        <span class="invalid-feedback" v-show="form.errors.has('zip')">
            @{{ form.errors.get('zip') }}
        </span>
    </div>
</div>

<!-- Country -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Country')}}</label>

    <div class="col-sm-6">
        <select class="form-control" v-model="form.country" :class="{'is-invalid': form.errors.has('country')}">
            @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                <option value="{{ $key }}">{{ $country }}</option>
            @endforeach
        </select>

        <span class="invalid-feedback" v-show="form.errors.has('country')">
            @{{ form.errors.get('country') }}
        </span>
    </div>
</div>
