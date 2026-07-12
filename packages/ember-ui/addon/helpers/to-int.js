import { helper } from '@ember/component/helper';
import numbersOnly from '@transitops/ember-core/utils/numbers-only';

export default helper(function fToInt([value]) {
    return parseInt(numbersOnly(value));
});
