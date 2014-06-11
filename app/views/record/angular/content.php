<h1>{{ record.record_name }}</h1>
<span class="record-type col-xs-12 item-{{ record.record_type_slug }} show-grid">{{ record.record_type }}</span>
<div ng-repeat="field in record.fields" class="row">
    <div class="col-xs-12 show-grid">
    <strong>{{ field.label }}:</strong> <pre>{{ field.value }}</pre>
    </div>
</div>