<label for="{{ field.id }}">{{ field.label }}</label>
<div ng-switch="field.type">
    <input ng-switch-when="text" type="text" name="{{ field.name }}" id="{{ field.id }}">
    <textarea ng-switch-when="textarea" name="{{ field.name }}" id="{{ field.id }}"></textarea>
    <input ng-switch-when="password" type="password" name="{{ field.name }}" id="{{ field.id }}">
</div>