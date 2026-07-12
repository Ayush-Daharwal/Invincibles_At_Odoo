import { module, test } from 'qunit';
import { setupTest } from '@transitops/console/tests/helpers';

module('Unit | Route | console', function (hooks) {
    setupTest(hooks);

    test('it exists', function (assert) {
        let route = this.owner.lookup('route:console');
        assert.ok(route);
    });
});
