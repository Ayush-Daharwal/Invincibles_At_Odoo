import ApplicationSerializer from '@transitops/ember-core/serializers/application';
import { EmbeddedRecordsMixin } from '@ember-data/serializer/rest';

export default class IntegratedVendorSerializer extends ApplicationSerializer.extend(EmbeddedRecordsMixin) {}
