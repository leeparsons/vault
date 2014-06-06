<h1>{{ record.record_name }}</h1>
<p>{{ record.record_type }}</p>
<div ng-repeat="field as record.fields">
    {{ field.label }}
</div>
