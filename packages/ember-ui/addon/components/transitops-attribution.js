import Component from '@glimmer/component';
import { inject as service } from '@ember/service';
import { action } from '@ember/object';
import config from 'ember-get-config';

export default class TransitopsAttributionComponent extends Component {
    @service modalsManager;

    licensingUrl = 'https://www.transitops.io';

    get disabled() {
        return config.APP?.disableTransitopsAttribution === true;
    }

    get appVersion() {
        return config.version ? `v${config.version}` : null;
    }

    @action openLegalNotice() {
        this.modalsManager.show('modals/transitops-legal-notice', {
            title: 'Transitops Legal Notices',
            acceptButtonText: 'Done',
            acceptButtonIcon: 'check',
            hideDeclineButton: true,
            modalClass: 'modal-md transitops-legal-notice-modal',
        });
    }
}
