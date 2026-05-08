@php
    $inputClasses = 'block w-full rounded-md border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] px-3 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] focus:border-[#1b1b18] dark:focus:border-[#EDEDEC] focus:outline-none focus:ring-1 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]';
    $checkboxLabelClasses = 'flex items-center gap-2 text-sm';
    $checkboxClasses = 'h-4 w-4 rounded border-[#19140035] dark:border-[#3E3E3A]';
    $sectionClasses = 'rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-5 shadow-sm';
    $sectionHeadingClasses = 'mb-4 text-sm font-semibold uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]';
    $labelClasses = 'mb-1 block text-sm font-medium';
    $errorClasses = 'mt-1 text-xs text-red-600 dark:text-red-400';
    $hintClasses = 'mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]';
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-md border border-red-200 dark:border-red-900/50 bg-red-50 dark:bg-red-950/40 px-4 py-3 text-sm text-red-700 dark:text-red-300">
        Please fix the errors below before saving.
    </div>
@endif

{{-- Nappy --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Nappy</h2>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-2">
            <label class="{{ $checkboxLabelClasses }}">
                <input type="checkbox" name="nappy_wet" value="1" {{ old('nappy_wet', $feed->nappy_wet) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
                Wet
            </label>
            <label class="{{ $checkboxLabelClasses }}">
                <input type="checkbox" name="nappy_poo" value="1" {{ old('nappy_poo', $feed->nappy_poo) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
                Poo
            </label>
        </div>
        <div>
            <label for="changed_by" class="{{ $labelClasses }}">Changed by</label>
            <select id="changed_by" name="changed_by" class="{{ $inputClasses }}">
                <option value="">— No one</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('changed_by', $feed->changed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <p class="{{ $hintClasses }}">Cleared automatically if no nappy was wet or pooey.</p>
            @error('changed_by') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

{{-- Feeding --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Feeding</h2>
    <div class="space-y-4">
        <label class="{{ $checkboxLabelClasses }}">
            <input type="checkbox" name="breast_fed" value="1" {{ old('breast_fed', $feed->breast_fed) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
            Breast fed
        </label>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="formula_ounces" class="{{ $labelClasses }}">Formula (oz)</label>
                <input id="formula_ounces" name="formula_ounces" type="number" step="0.01" min="0" max="99.99" placeholder="0.00" value="{{ old('formula_ounces', $feed->formula_ounces) }}" class="{{ $inputClasses }}">
                @error('formula_ounces') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="fed_by" class="{{ $labelClasses }}">Fed by</label>
                <select id="fed_by" name="fed_by" class="{{ $inputClasses }}">
                    <option value="">— No one</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('fed_by', $feed->fed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                <p class="{{ $hintClasses }}">Cleared automatically if formula is empty or 0.</p>
                @error('fed_by') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</section>

{{-- Skin-to-skin --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Skin-to-skin</h2>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="skin_to_skin_minutes" class="{{ $labelClasses }}">Minutes</label>
            <input id="skin_to_skin_minutes" name="skin_to_skin_minutes" type="number" step="1" min="0" max="600" placeholder="0" value="{{ old('skin_to_skin_minutes', $feed->skin_to_skin_minutes) }}" class="{{ $inputClasses }}">
            @error('skin_to_skin_minutes') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="skin_to_skin_with" class="{{ $labelClasses }}">With</label>
            <select id="skin_to_skin_with" name="skin_to_skin_with" class="{{ $inputClasses }}">
                <option value="">— No one</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('skin_to_skin_with', $feed->skin_to_skin_with) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('skin_to_skin_with') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

{{-- Sun --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Time in sun</h2>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="time_in_sun" class="{{ $labelClasses }}">Minutes</label>
            <input id="time_in_sun" name="time_in_sun" type="number" step="1" min="0" max="99" placeholder="0" value="{{ old('time_in_sun', $feed->time_in_sun) }}" class="{{ $inputClasses }}">
            @error('time_in_sun') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="time_in_sun_with" class="{{ $labelClasses }}">With</label>
            <select id="time_in_sun_with" name="time_in_sun_with" class="{{ $inputClasses }}">
                <option value="">— No one</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('time_in_sun_with', $feed->time_in_sun_with) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('time_in_sun_with') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

{{-- Clothes --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Clothes</h2>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="{{ $checkboxLabelClasses }}">
            <input type="checkbox" name="change_of_clothes" value="1" {{ old('change_of_clothes', $feed->change_of_clothes) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
            Change of clothes
        </label>
        <div>
            <label for="clothes_changed_by" class="{{ $labelClasses }}">Clothes changed by</label>
            <select id="clothes_changed_by" name="clothes_changed_by" class="{{ $inputClasses }}">
                <option value="">— No one</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('clothes_changed_by', $feed->clothes_changed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('clothes_changed_by') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

{{-- Other observations --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Other observations</h2>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="cry_level" class="{{ $labelClasses }}">Cry level <span class="text-[#706f6c] dark:text-[#A1A09A]">(0–10)</span></label>
            <input id="cry_level" name="cry_level" type="number" step="1" min="0" max="10" required value="{{ old('cry_level', $feed->cry_level ?? 0) }}" class="{{ $inputClasses }}">
            @error('cry_level') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="temperature" class="{{ $labelClasses }}">Temperature (&deg;C)</label>
            <input id="temperature" name="temperature" type="number" step="0.01" min="30" max="45" placeholder="36.50" value="{{ old('temperature', $feed->temperature) }}" class="{{ $inputClasses }}">
            @error('temperature') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2">
        <label class="{{ $checkboxLabelClasses }}">
            <input type="checkbox" name="table_wee" value="1" {{ old('table_wee', $feed->table_wee) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
            Table wee
        </label>
        <label class="{{ $checkboxLabelClasses }}">
            <input type="checkbox" name="table_poo" value="1" {{ old('table_poo', $feed->table_poo) ? 'checked' : '' }} class="{{ $checkboxClasses }}">
            Table poo
        </label>
    </div>
</section>

{{-- Notes --}}
<section class="{{ $sectionClasses }}">
    <h2 class="{{ $sectionHeadingClasses }}">Notes</h2>
    <textarea id="notes" name="notes" rows="3" placeholder="Anything worth remembering…" class="{{ $inputClasses }}">{{ old('notes', $feed->notes) }}</textarea>
    @error('notes') <p class="{{ $errorClasses }}">{{ $message }}</p> @enderror
</section>
