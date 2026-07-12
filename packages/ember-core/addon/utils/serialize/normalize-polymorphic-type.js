const lowercase = (string) => string.toLowerCase();

export default function serializeNormalizePolymorphicType(polymorphicTypeValue, defaultValue = null) {
    // encode first
    const encodedPolymorphicTypeValue = encodeURI(polymorphicTypeValue);
    // if encoded is invalid send the default value or the original value back
    if (!encodedPolymorphicTypeValue.includes('%5C')) {
        return defaultValue || polymorphicTypeValue;
    }
    // from transitops api should be something like Transitops\Models\Model
    // change value to ember-data polymorphic type
    return lowercase(encodedPolymorphicTypeValue.split('%5C').reverse()[0]);
}
