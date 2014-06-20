<div ng-switch="field.type">
    <label for="{{ field.id }}" class="cols-xs-12">{{ field.label }}</label>
    <input ng-switch-when="text" type="text" name="{{ field.name }}" id="{{ field.id }}" class="form-control">
    <textarea ng-switch-when="textarea" name="{{ field.name }}" id="{{ field.id }}" class="form-control"></textarea>
    <input ng-switch-when="password" type="password" name="{{ field.name }}" id="{{ field.id }}" class="form-control">
</div>