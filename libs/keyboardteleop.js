/**
 * @author Russell Toris - rctoris@wpi.edu
 * @author Jhonyfer Angarita M. jhangaritamo@unal.edu.co
 */

var KEYBOARDTELEOP = KEYBOARDTELEOP || {
    REVISION: '0.3.0'
};

/**
 * @author Russell Toris - rctoris@wpi.edu
 * @author Jhonyfer Angarita M. jhangaritamo@unal.edu.co
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
 *   * linearVelScale (optional) - scale for linear speed
 *   * angularVelScale (optional) - scale for angular speed
 *   * buttonUp (optional) - button that will send forward movement commands
 *   * buttonDown (optional) - button that will send backward movement commands
 *   * buttonRight (optional) - button that will send turn right commands
 *   * buttonLeft (optional) - button that will send turn left commands
 *   * enable - enables or dissables the send of commands
 */
KEYBOARDTELEOP.Teleop = function (options) {
    var that = this;
    options = options || {};
    var ros = options.ros;
    var topic = options.topic || '/cmd_vel';

    // permanent throttle
    var throttle = options.throttle || 1.0;

    // used to externally throttle the speed (e.g., from a slider)
    this.linearVelScale = options.linearVelScale || 1.0;
    this.angularVelScale = options.angularVelScale || 1.0;

    // Enable or disable
    this.enable = options.enable || true;

    // Buttons for virtual keyboard
    this.buttonUp = options.buttonUp || null;
    this.buttonDown = options.buttonDown || null;
    this.buttonLeft = options.buttonLeft || null;
    this.buttonRight = options.buttonRight || null;

    // linear x and y movement and angular z movement
    var x = 0;
    var y = 0;
    var z = 0;

    var cmdVel = new ROSLIB.Topic({
        ros: ros,
        name: topic,
        messageType: 'geometry_msgs/Twist'
    });

    /**
     * Sets up a key listener on the page used for keyboard teleoperation or virtual
     * key (button)
     * @param {*} keyCode 
     * @param {*} buttonDown 
     */
    var handleKey = function (keyCode, buttonDown) {
        // used to check for changes in speed
        var oldX = x;
        var oldY = y;
        var oldZ = z;

        var pub = true;

        var speed = 0;
        var angular = 0;

        // throttle the speed by the slider and throttle constant
        if (buttonDown === true) {
            speed = throttle * that.linearVelScale;
            angular = throttle * that.angularVelScale;
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
    // buttonUp
    if (this.buttonUp != null) {
        this.buttonUp.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(87, true);
            }
        }, false);
        this.buttonUp.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(87, false);
            }
        }, false);
        this.buttonUp.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(87, false);
            }
        }, false);
    }
    // buttonDown
    if (this.buttonDown != null) {
        this.buttonDown.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(83, true);
            }
        }, false);
        this.buttonDown.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(83, false);
            }
        }, false);
        this.buttonDown.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(83, false);
            }
        }, false);
    }
    // buttonLeft
    if (this.buttonLeft != null) {
        this.buttonLeft.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(65, true);
            }
        }, false);
        this.buttonLeft.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(65, false);
            }
        }, false);
        this.buttonLeft.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(65, false);
            }
        }, false);
    }
    // buttonRight
    if (this.buttonRight != null) {
        this.buttonRight.addEventListener('mousedown', function (e) {
            if (that.enable) {
                handleKey(68, true);
            }
        }, false);
        this.buttonRight.addEventListener('mouseup', function (e) {
            if (that.enable) {
                handleKey(68, false);
            }
        }, false);
        this.buttonRight.addEventListener('mouseleave', function (e) {
            if (that.enable) {
                handleKey(68, false);
            }
        }, false);
    }

};
KEYBOARDTELEOP.Teleop.prototype.__proto__ = EventEmitter2.prototype;
