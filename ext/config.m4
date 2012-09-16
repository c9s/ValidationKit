PHP_ARG_ENABLE(validationkit, whether to enable validation kit, [ --enable-validationkit   Enable Validation kit])

if test "$PHP_VALIDATIONKIT" = "yes"; then
  AC_DEFINE(HAVE_VALIDATIONKIT, 1, [Whether you have Validation Kit])
  PHP_NEW_EXTENSION(validationkit, validationkit.c kernel/main.c kernel/fcall.c kernel/require.c kernel/debug.c kernel/assert.c kernel/object.c kernel/array.c kernel/operators.c kernel/concat.c kernel/exception.c kernel/memory.c validator.c validator/email.c validator/string_length.c validator/string.c, $ext_shared)
fi
