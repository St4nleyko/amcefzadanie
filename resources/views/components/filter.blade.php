<form method="GET" action="{{ route($route) }}" class="mb-4">
    <div class="row">
        <!-- Category Filter -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="category">{{ __('Category') }}</label>
                <select name="category" id="category" class="form-control">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!--completed-->
        <div class="col-md-4">
            <div class="form-group">
                <label for="is_completed">{{ __('Completion Status') }}</label>
                <select name="is_completed" id="is_completed" class="form-control">
                    <option value="">{{ __('All') }}</option>
                    <option value="1" {{ request('is_completed') == '1' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    <option value="0" {{ request('is_completed') == '0' ? 'selected' : '' }}>{{ __('Incomplete') }}</option>
                </select>
            </div>
        </div>

        <!-- shared filter  -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="ownership">{{ __('Ownership') }}</label>
                <select name="ownership" id="ownership" class="form-control">
                    <option value="">{{ __('All') }}</option>
                    <option value="mine" {{ request('ownership') == 'mine' ? 'selected' : '' }}>{{ __('My Items') }}</option>
                    <option value="shared" {{ request('ownership') == 'shared' ? 'selected' : '' }}>{{ __('Shared with Me') }}</option>
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">{{ __('Filter') }}</button>
</form>
