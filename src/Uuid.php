<?php
/**
 * This class implements the generation of Version 4 and Version 5 UUIDs.
 *
 * UUIDs are 128 bit numbers which are intended to have a high likelihood of
 * uniqueness over space and time and are computationally difficult to guess.
 * They are globally unique identifiers which can be locally generated without
 * contacting a global registration authority. UUIDs are intended as unique
 * identifiers for both mass tagging objects with an extremely short lifetime
 * and to reliably identifying very persistent objects across a network.
 *
 * The meaning of each bit is defined by any of several variants.  This class
 * implements the x01 variant, sometimes called DCE 1.1,
 *
 * Version 4 is meant for generating UUIDs from truly-random or
 * pseudo-random numbers.
 *
 * Version 5 is meant for generating UUIDs from "names" that are drawn from,
 * and unique within, some "name space".
 *
 * In its canonical form, a UUID is represented by 32 lowercase hexadecimal
 * digits, displayed in five groups separated by hyphens, in the form
 * 8-4-4-4-12 for a total of 36 characters (32 alphanumeric characters and
 * four hyphens). For example:
 * 123e4567-e89b-12d3-a456-426655440000
 *
 * @standard https://www.ietf.org/rfc/rfc4122.txt RFC-4122
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

namespace Cxj;


class Uuid
{
    /*
     * In C/C++ terms, the 128 bits of the UUID are defined thusly:
     *
     * typedef struct {
     *     unsigned32  time_low;
     *     unsigned16  time_mid;
     *     unsigned16  time_hi_and_version;
     *     unsigned8   clock_seq_hi_and_reserved;
     *     unsigned8   clock_seq_low;
     *     byte        node[6];
     * } uuid_t;
     */

    /**
     * Version 4 (random)
     * This algorithm sets the version number (4 bits) as well as two reserved
     * bits.  All other bits (the remaining 122 bits) are set using a random
     * or pseudo-random data source. Version 4 UUIDs have the form
     * xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx where x is any hexadecimal digit
     * and y is one of 8, 9, A, or B.
     *
     * @return string
     */
    public static function v4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant.
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Version 5 (SHA-1 hash)
     * This algorithm requires a namespace (another valid UUID) and a value
     * (the name), and uses SHA-1 hashing.  Given the same namespace and name,
     * the output is always the same.  Since namespace has to be a valid
     * UUID, one could use a Version 4 UUID as input if desired if one does
     * not already have some existing UUID to use for that purpose.
     *
     * @param $namespace
     * @param $name
     * @return bool|string
     */
    public static function v5($namespace, $name)
    {
        if (!self::is_valid($namespace)) return false;

        // Get hexadecimal components of namespace.
        $nhex = str_replace(array('-', '{', '}'), '', $namespace);

        // Binary Value.
        $nstr = '';

        // Convert Namespace UUID to bits.
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }

        // Calculate hash value.
        $hash = sha1($nstr . $name);

        return sprintf('%08s-%04s-%04x-%04x-%12s',

            // 32 bits for "time_low"
            substr($hash, 0, 8),

            // 16 bits for "time_mid"
            substr($hash, 8, 4),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 5
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant.
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    /**
     * Simply check that the UUID string matches the canonical format
     * of 32 lowercase hexadecimal digits arranged with hyphens in the
     * format 8-4-4-4-12.
     *
     * @param $uuid
     * @return bool
     */
    public static function is_valid($uuid)
    {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' .
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
}





$v4uuid = UUID::v4();
$v5uuid = UUID::v5($v4uuid, 'SomeRandomString');
$v5uuid2 = UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');


echo "v4: $v4uuid" .PHP_EOL;
echo "v5: $v5uuid" .PHP_EOL;
echo "v5: $v5uuid2" .PHP_EOL;

