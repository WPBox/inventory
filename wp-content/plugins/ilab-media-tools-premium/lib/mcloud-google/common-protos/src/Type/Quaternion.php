<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/type/quaternion.proto

namespace MediaCloud\Vendor\Google\Type;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * A quaternion is defined as the quotient of two directed lines in a
 * three-dimensional space or equivalently as the quotient of two Euclidean
 * vectors (https://en.wikipedia.org/wiki/Quaternion).
 * Quaternions are often used in calculations involving three-dimensional
 * rotations (https://en.wikipedia.org/wiki/Quaternions_and_spatial_rotation),
 * as they provide greater mathematical robustness by avoiding the gimbal lock
 * problems that can be encountered when using Euler angles
 * (https://en.wikipedia.org/wiki/Gimbal_lock).
 * Quaternions are generally represented in this form:
 *     w + xi + yj + zk
 * where x, y, z, and w are real numbers, and i, j, and k are three imaginary
 * numbers.
 * Our naming choice `(x, y, z, w)` comes from the desire to avoid confusion for
 * those interested in the geometric properties of the quaternion in the 3D
 * Cartesian space. Other texts often use alternative names or subscripts, such
 * as `(a, b, c, d)`, `(1, i, j, k)`, or `(0, 1, 2, 3)`, which are perhaps
 * better suited for mathematical interpretations.
 * To avoid any confusion, as well as to maintain compatibility with a large
 * number of software libraries, the quaternions represented using the protocol
 * buffer below *must* follow the Hamilton convention, which defines `ij = k`
 * (i.e. a right-handed algebra), and therefore:
 *     i^2 = j^2 = k^2 = ijk = −1
 *     ij = −ji = k
 *     jk = −kj = i
 *     ki = −ik = j
 * Please DO NOT use this to represent quaternions that follow the JPL
 * convention, or any of the other quaternion flavors out there.
 * Definitions:
 *   - Quaternion norm (or magnitude): `sqrt(x^2 + y^2 + z^2 + w^2)`.
 *   - Unit (or normalized) quaternion: a quaternion whose norm is 1.
 *   - Pure quaternion: a quaternion whose scalar component (`w`) is 0.
 *   - Rotation quaternion: a unit quaternion used to represent rotation.
 *   - Orientation quaternion: a unit quaternion used to represent orientation.
 * A quaternion can be normalized by dividing it by its norm. The resulting
 * quaternion maintains the same direction, but has a norm of 1, i.e. it moves
 * on the unit sphere. This is generally necessary for rotation and orientation
 * quaternions, to avoid rounding errors:
 * https://en.wikipedia.org/wiki/Rotation_formalisms_in_three_dimensions
 * Note that `(x, y, z, w)` and `(-x, -y, -z, -w)` represent the same rotation,
 * but normalization would be even more useful, e.g. for comparison purposes, if
 * it would produce a unique representation. It is thus recommended that `w` be
 * kept positive, which can be achieved by changing all the signs when `w` is
 * negative.
 *
 * Generated from protobuf message <code>google.type.Quaternion</code>
 */
class Quaternion extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * The x component.
     *
     * Generated from protobuf field <code>double x = 1;</code>
     */
    private $x = 0.0;
    /**
     * The y component.
     *
     * Generated from protobuf field <code>double y = 2;</code>
     */
    private $y = 0.0;
    /**
     * The z component.
     *
     * Generated from protobuf field <code>double z = 3;</code>
     */
    private $z = 0.0;
    /**
     * The scalar component.
     *
     * Generated from protobuf field <code>double w = 4;</code>
     */
    private $w = 0.0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $x
     *           The x component.
     *     @type float $y
     *           The y component.
     *     @type float $z
     *           The z component.
     *     @type float $w
     *           The scalar component.
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Type\Quaternion::initOnce();
        parent::__construct($data);
    }

    /**
     * The x component.
     *
     * Generated from protobuf field <code>double x = 1;</code>
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * The x component.
     *
     * Generated from protobuf field <code>double x = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setX($var)
    {
        GPBUtil::checkDouble($var);
        $this->x = $var;

        return $this;
    }

    /**
     * The y component.
     *
     * Generated from protobuf field <code>double y = 2;</code>
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * The y component.
     *
     * Generated from protobuf field <code>double y = 2;</code>
     * @param float $var
     * @return $this
     */
    public function setY($var)
    {
        GPBUtil::checkDouble($var);
        $this->y = $var;

        return $this;
    }

    /**
     * The z component.
     *
     * Generated from protobuf field <code>double z = 3;</code>
     * @return float
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * The z component.
     *
     * Generated from protobuf field <code>double z = 3;</code>
     * @param float $var
     * @return $this
     */
    public function setZ($var)
    {
        GPBUtil::checkDouble($var);
        $this->z = $var;

        return $this;
    }

    /**
     * The scalar component.
     *
     * Generated from protobuf field <code>double w = 4;</code>
     * @return float
     */
    public function getW()
    {
        return $this->w;
    }

    /**
     * The scalar component.
     *
     * Generated from protobuf field <code>double w = 4;</code>
     * @param float $var
     * @return $this
     */
    public function setW($var)
    {
        GPBUtil::checkDouble($var);
        $this->w = $var;

        return $this;
    }

}

