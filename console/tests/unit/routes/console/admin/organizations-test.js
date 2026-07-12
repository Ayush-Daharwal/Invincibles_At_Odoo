import { module, test } from 'qunit';
import { setupTest } from '@transitops/console/tests/helpers';

module('Unit | Route | console/admin/organizations', function (hooks) {
    setupTest(hooks);

    test('it exists', function (assert) {
        let route = this.owner.lookup('route:console/admin/organizations');
        assert.ok(route);
    });
});
