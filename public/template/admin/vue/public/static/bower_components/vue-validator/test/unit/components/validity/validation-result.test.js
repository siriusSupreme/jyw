import States from '../../../../src/components/validity/states'
import Computed from '../../../../src/components/validity/computed'
import Lifecycles from '../../../../src/components/validity/lifecycles'
import Methods from '../../../../src/components/validity/methods'

const { props, data } = States(Vue)
const computed = Computed(Vue)
const { created } = Lifecycles(Vue)
const methods = Methods(Vue)

describe('validity component: validation result', () => {
  let vm
  beforeEach(done => {
    vm = new Vue({
      props,
      data,
      computed,
      created,
      methods,
      propsData: {
        field: 'field1',
        child: {}, // dummy
        validators: {
          required: true
        }
      }
    })
    done()
  })

  describe('valid', () => {
    it('should be validated', done => {
      // first state
      assert(vm.valid === true)
      // set invalid validation raw result
      vm.results['required'] = false
      waitForUpdate(() => {
        assert(vm.valid === false)
        // set valid validation raw result
        vm.results['required'] = true
      }).then(() => {
        assert(vm.valid === true)
      }).then(done)
    })
  })

  describe('invalid', () => {
    it('should be validated', done => {
      // first state
      assert(vm.invalid === false)
      // set invalid validation raw result
      vm.results['required'] = false
      waitForUpdate(() => {
        assert(vm.invalid === true)
        // set valid validation raw result
        vm.results['required'] = true
      }).then(() => {
        assert(vm.invalid === false)
      }).then(done)
    })
  })

  describe('touched', () => {
    it('should be validated', done => {
      // first state
      assert(vm.touched === false)
      // simulate touched updating
      vm.willUpdateTouched()
      waitForUpdate(() => {
        assert(vm.touched === true)
        // simulate touched updating again
        vm.willUpdateTouched()
      }).then(() => {
        assert(vm.touched === true)
      }).then(done)
    })
  })

  describe('untouched', () => {
    it('should be validated', done => {
      // first state
      assert(vm.untouched === true)
      // simulate touched updating
      vm.willUpdateTouched()
      waitForUpdate(() => {
        assert(vm.untouched === false)
        // simulate touched updateting again
        vm.willUpdateTouched()
      }).then(() => {
        assert(vm.untouched === false)
      }).then(done)
    })
  })

  describe('dirty', () => {
    it('should be validated', done => {
      // setup stub
      spyOn(vm, 'checkModified').and.returnValues(true, false)
      // first state
      assert(vm.dirty === false)
      // simulate dirty updating
      vm.willUpdateDirty()
      waitForUpdate(() => {
        assert(vm.dirty === true)
        // simulate dirty updating again
        vm.willUpdateDirty()
      }).then(() => {
        assert(vm.dirty === true)
      }).then(done)
    })
  })

  describe('pristine', () => {
    it('should be validated', done => {
      // setup stub
      spyOn(vm, 'checkModified').and.returnValues(true, false)
      // first state
      assert(vm.pristine === true)
      // simulate pristine updating
      vm.willUpdateDirty()
      waitForUpdate(() => {
        assert(vm.pristine === false)
        // simulate pristine updating again
        vm.willUpdateDirty()
      }).then(() => {
        assert(vm.pristine === false)
      }).then(done)
    })
  })

  describe('modified', () => {
    it('should be validated', done => {
      // setup stub
      spyOn(vm, 'checkModified').and.returnValues(true, false)
      // first state
      assert(vm.modified === false)
      // simulate modified updating
      vm.willUpdateModified()
      waitForUpdate(() => {
        assert(vm.modified === true)
        // simulate modified updating again
        vm.willUpdateModified()
      }).then(() => {
        assert(vm.modified === false)
      }).then(done)
    })
  })

  describe('result', () => {
    it('should be validated', done => {
      let result
      // setup stub
      spyOn(vm, 'checkModified').and.returnValues(true, true, false, false)
      // first state
      result = vm.result
      assert(result.valid === true)
      assert(result.invalid === false)
      assert(result.touched === false)
      assert(result.untouched === true)
      assert(result.dirty === false)
      assert(result.pristine === true)
      assert(result.modified === false)
      assert(result.required === false)
      assert(result.errors === undefined)

      // simulate some updating
      vm.willUpdateDirty()
      vm.willUpdateModified()
      vm.willUpdateTouched()
      // set invalid validation raw result
      vm.results['required'] = false
      waitForUpdate(() => {
        result = vm.result
        assert(result.valid === false)
        assert(result.invalid === true)
        assert(result.touched === true)
        assert(result.untouched === false)
        assert(result.dirty === true)
        assert(result.pristine === false)
        assert(result.modified === true)
        assert(result.required === true)
        assert.deepEqual(result.errors, [{
          field: 'field1', validator: 'required'
        }])

        // set invalid validation raw result
        vm.results['required'] = 'required field1'
      }).then(() => {
        result = vm.result
        assert(result.valid === false)
        assert(result.invalid === true)
        assert(result.touched === true)
        assert(result.untouched === false)
        assert(result.dirty === true)
        assert(result.pristine === false)
        assert(result.modified === true)
        assert.deepEqual(result.required, 'required field1')
        assert.deepEqual(result.errors, [{
          field: 'field1', validator: 'required', message: 'required field1'
        }])
      }).then(done)
    })
  })
})
