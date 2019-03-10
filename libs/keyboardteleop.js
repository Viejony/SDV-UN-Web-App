/**
 * @author Russell Toris - rctoris@wpi.edu
 */

var KEYBOARDTELEOP = KEYBOARDTELEOP || {
    REVISION: '0.3.0'
};

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/**
 * Manages connection to the server and all interactions with ROS.
 *
 * Emits the following events:
 *   * 'change' - emitted with a change in speed occurs
 *
 * @constructor
 * @param options - possible keys include:
 *   * ros - the ROSLIB.Ros connection handle
 *   * topic (optional) - the Twist topic to publish to, like '/cmd_vel'
 *   * throttle (optional) - a constant throttle for the speed
 */
KEYBOARDTELEOP.Teleop = function (options) {
    var that = this;
    options = options || {};
    var ros = options.ros;
    var topic = options.topic || '/cmd_vel';
    // permanent throttle
    var throttle = options.throttle || 1.0;

    // used to externally throttle the speed (e.g., from a slider)
    this.linear_vel_scale = 1.0;
    this.angular_vel_scale = 1.0;

    // Enable or disable
    this.enable = options.enable || true;

    // Buttons for virtual keyboard
    this.keyUp = options.keyUp || null;
    this.keyDown = options.keyDown || null;
    this.keyLeft = options.keyLeft || null;
    this.keyRight = options.keyRight || null;

    // linear x and y movement and angular z movement
    var x = 0;
    var y = 0;
    var z = 0;

    var cmdVel = new ROSLIB.Topic({
        ros: ros,
        name: topic,
        messageType: 'geometry_msgs/Twist'
    });

    // sets up a key listener on the page used for keyboard teleoperation
    var handleKey = function (keyCode, keyDown) {
        // used to check for changes in speed
        var oldX = x;
        var oldY = y;
        var oldZ = z;

        var pub = true;

        var speed = 0;
        var angular = 0;

        // throttle the speed by the slider and throttle constant
        if (keyDown === true) {
            speed = throttle * that.linear_vel_scale;
            angular = throttle * that.angular_vel_scale;
        }
        
        // check which key was pressed
        switch (keyCode) {
            case 65:
                // turn left
                z = 1.0 * angular;
                break;
            case 87:
                // up
                x = 1.0 * speed;
                break;
            case 68:
                // turn right
                z = -1.0 * angular;
                break;
            case 83:
                // down
                x = -1.0 * speed;
                break;
            case 69:
                // strafe right
                y = -1.0 * speed;
                break;
            case 81:
                // strafe left
                y = 1.0 * speed;
                break;
            default:
                pub = false;
        }

        // publish the command
        if (pub === true) {
            var twist = new ROSLIB.Message({
                angular: {
                    x: 0,
                    y: 0,
                    z: z
                },
                linear: {
                    x: x,
                    y: y,
                    z: z
                }
            });
            cmdVel.publish(twist);

            // check for changes
            if (oldX !== x || oldY !== y || oldZ !== z) {
                that.emit('change', twist);
            }
        }
    };

    // handle the key
    var body = document.getElementsByTagName('body')[0];
    body.addEventListener('keydown', function (e) {
        if (that.enable) {
            handleKey(e.keyCode, true);
        }
    }, false);
    body.addEventListener('keyup', function (e) {
        if (that.enable) {
            handleKey(e.keyCode, false);
        }
    }, false);

    // handle buttons
    if (this.keyUp != null) {
        this.keyUp.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(87, true);
            }
        }, false);
        this.keyUp.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(87, false);
            }
        }, false);
        this.keyUp.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(87, false);
            }
        }, false);
    }
    if (this.keyDown != null) {
        this.keyDown.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(83, true);
            }
        }, false);
        this.keyDown.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(83, false);
            }
        }, false);
        this.keyDown.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(83, false);
            }
        }, false);
    }
    if (this.keyLeft != null) {
        this.keyLeft.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(65, true);
            }
        }, false);
        this.keyLeft.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(65, false);
            }
        }, false);
        this.keyLeft.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(65, false);
            }
        }, false);
    }
    if (this.keyRight != null) {
        this.keyRight.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(68, true);
            }
        }, false);
        this.keyRight.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(68, false);
            }
        }, false);
        this.keyRight.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(68, false);
            }
        }, false);
    }

};
KEYBOARDTELEOP.Teleop.prototype.__proto__ = EventEmitter2.prototype;
