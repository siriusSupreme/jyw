import States from '../../../../src/components/validity/states'
import Computed from '../../../../src/components/validity/computed'
import Lifecycles from '../../../../src/components/validity/lifecycles'
import Methods from '../../../../src/components/validity/methods'

const { props, data } = States(Vue)
const computed = Computed(Vue)
const { created } = Lifecycles(Vue)
const methods = Methods(Vue)

describe('validity component: validate', () => {
  const baseOptions = {
    props,
    data,
    computed,
    created,
    methods
  }

  describe('built-in validator', () => {
    it('should be work', done => {
      baseOptions.propsData = {
        field: 'field1',
        child: {}, // dummy
        validators: {
          required: true
        }
      }
      const vm = new Vue(baseOptions)
      // invalid
      vm.validate('required', '', (err, ret, msg) => {
        assert(err === null)
        assert(ret === false)
        assert(msg === undefined)
        assert(vm.valid === false)
        assert(vm.invalid === true)
        assert(vm.result.valid === false)
        assert(vm.result.invalid === true)
        assert(vm.result.required === true)
        // valid
        vm.validate('required', 'value', (err, ret, msg) => {
          assert(err === null)
          assert(ret === true)
          assert(msg === undefined)
          assert(vm.valid === true)
          assert(vm.invalid === false)
          assert(vm.result.valid === true)
          assert(vm.result.invalid === false)
          assert(vm.result.required === false)
          done()
        })
      })
    })
  })

  describe('custom validator', () => {
    it('should be work', done => {
      baseOptions.propsData = {
        field: 'field1',
        child: {}, // dummy
        validators: {
          email: {
            message: 'invalid email'
          },
          numeric: true
        }
      }
      baseOptions.validators = {
        email (val) {
          return /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(val)
        },
        numeric: {
          message (field) {
            return `invalid ${field} value`
          },
          check (val) {
            return /^[-+]?[0-9]+$/.test(val)
          }
        }
      }
      const vm = new Vue(baseOptions)
      vm.validate('email', '', (err, ret, msg) => {
        assert(err === null)
        assert(ret === false)
        assert.equal(msg, 'invalid email')
        assert(vm.valid === false)
        assert(vm.invalid === true)
        assert(vm.result.valid === false)
        assert(vm.result.invalid === true)
        assert.equal(vm.result.email, 'invalid email')
        vm.validate('numeric', 'foobar', (err, ret, msg) => {
          assert(err === null)
          assert(ret === false)
          assert.equal(msg, 'invalid field1 value')
          assert(vm.valid === false)
          assert(vm.invalid === true)
          assert(vm.result.valid === false)
          assert(vm.result.invalid === true)
          assert.equal(vm.result.numeric, 'invalid field1 value')
          vm.validate('email', 'foo@domain.com', (err, ret, msg) => {
            assert(err === null)
            assert(ret === true)
            assert(msg === undefined)
            assert(vm.valid === false)
            assert(vm.invalid === true)
            assert(vm.result.valid === false)
            assert(vm.result.invalid === true)
            assert(vm.result.email === false)
            vm.validate('numeric', '12345', (err, ret, msg) => {
              assert(err === null)
              assert(ret === true)
              assert(msg === undefined)
              assert(vm.valid === true)
              assert(vm.invalid === false)
              assert(vm.result.valid === true)
              assert(vm.result.invalid === false)
              assert(vm.result.numeric === false)
              done()
            })
          })
        })
      })
    })
  })

  describe('async validator', () => {
    beforeEach(() => {
      baseOptions.propsData = {
        field: 'field1',
        child: {}, // dummy
        validators: ['exist']
      }
    })

    describe('function', () => {
      describe('resolve', () => {
        it('should be work', done => {
          baseOptions.validators = {
            exist (val) {
              return (resolve, reject) => {
                setTimeout(() => { resolve() }, 5)
              }
            }
          }
          const vm = new Vue(baseOptions)
          vm.validate('exist', 'foo', (err, ret, msg) => {
            assert(err === null)
            assert(ret === true)
            assert(msg === undefined)
            assert(vm.valid === true)
            assert(vm.invalid === false)
            assert(vm.result.valid === true)
            assert(vm.result.invalid === false)
            assert(vm.result.exist === false)
            done()
          })
        })
      })

      describe('reject', () => {
        it('should be work', done => {
          baseOptions.validators = {
            exist (val) {
              return (resolve, reject) => {
                setTimeout(() => { reject('already exist') }, 5)
              }
            }
          }
          const vm = new Vue(baseOptions)
          vm.validate('exist', 'foo', (err, ret, msg) => {
            assert(err === null)
            assert(ret === false)
            assert.equal(msg, 'already exist')
            assert(vm.valid === false)
            assert(vm.invalid === true)
            assert(vm.result.valid === false)
            assert(vm.result.invalid === true)
            assert.equal(vm.result.exist, 'already exist')
            done()
          })
        })
      })
    })

    describe('promise', () => {
      describe('resolve', () => {
        it('should be work', done => {
          baseOptions.validators = {
            exist (val) {
              return new Promise((resolve, reject) => {
                setTimeout(() => { resolve() }, 5)
              })
            }
          }
          const vm = new Vue(baseOptions)
          vm.validate('exist', 'foo', (err, ret, msg) => {
            assert(err === null)
            assert(ret === true)
            assert(msg === undefined)
            assert(vm.valid === true)
            assert(vm.invalid === false)
            assert(vm.result.valid === true)
            assert(vm.result.invalid === false)
            assert(vm.result.exist === false)
            done()
          })
        })
      })

      describe('reject', () => {
        it('should be work', done => {
          baseOptions.validators = {
            exist (val) {
              return new Promise((resolve, reject) => {
                setTimeout(() => { reject('already exist') }, 5)
              })
            }
          }
          const vm = new Vue(baseOptions)
          vm.validate('exist', 'foo', (err, ret, msg) => {
            assert(err === null)
            assert(ret === false)
            assert.equal(msg, 'already exist')
            assert(vm.valid === false)
            assert(vm.invalid === true)
            assert(vm.result.valid === false)
            assert(vm.result.invalid === true)
            assert.equal(vm.result.exist, 'already exist')
            done()
          })
        })
      })
    })
  })

  describe('all validators running', () => {
    it('should be work', done => {
      baseOptions.propsData = {
        field: 'field1',
        child: {}, // dummy
        validators: ['required', 'numeric', 'exist']
      }
      baseOptions.validators = {
        numeric: {
          check (val) {
            return /^[-+]?[0-9]+$/.test(val)
          }
        },
        exist (val) {
          return new Promise((resolve, reject) => {
            setTimeout(() => { resolve() }, 5)
          })
        }
      }
      const vm = new Vue(baseOptions)
      spyOn(vm, 'getValue').and.returnValues('12345')
      const handler = jasmine.createSpy()
      vm.$on('validate', handler)
      waitForUpdate(() => {
        vm.validate()
      }).thenWaitFor(6).then(() => {
        const calls = handler.calls
        assert(calls.count() === 3)
        assert.equal(calls.argsFor(0)[0], 'required')
        assert(calls.argsFor(0)[1].result === true)
        assert.equal(calls.argsFor(1)[0], 'numeric')
        assert(calls.argsFor(1)[1].result === true)
        assert.equal(calls.argsFor(2)[0], 'exist')
        assert(calls.argsFor(2)[1].result === true)
      }).then(done)
    })
  })

  describe('already running', () => {
    it('should be occured already error', done => {
      baseOptions.propsData = {
        field: 'field1',
        child: {}, // dummy
        validators: ['exist']
      }
      baseOptions.validators = {
        exist (val) {
          return new Promise((resolve, reject) => {
            setTimeout(() => { resolve() }, 5)
          })
        }
      }
      const vm = new Vue(baseOptions)
      assert(vm.validate('exist', 'foo', done) === true)
      assert(vm.validate('exist', 'foo') === false)
    })
  })
})
