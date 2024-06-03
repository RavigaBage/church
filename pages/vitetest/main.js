import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
import { OrbitControls } from "three/addons/controls/OrbitControls.js";

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(window.devicePixelRatio);
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
document.body.appendChild(renderer.domElement);

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(
  45,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enablePan = false;
controls.minDistance = 5;
controls.maxDistance = 20;
controls.minPolarAngle = 0.5;
controls.maxPolarAngle = 1.5;
controls.autoRotate = false;
controls.target = new THREE.Vector3(0, 1, 0);
controls.update();

const geometry = new THREE.PlaneGeometry(20, 20, 32, 32);
geometry.rotateX(-Math.PI / 2);
const material = new THREE.MeshBasicMaterial({
  color: 0x555555,
  side: THREE.DoubleSide,
});
const cube = new THREE.Mesh(geometry, material);
cube.castShadow = false;
cube.receiveShadow = true;
const spotlight = new THREE.SpotLight(0xffffff, 3, 100, 0.2, 0.5);
spotlight.castShadow = true;
spotlight.position.set(0, 25, 0);
scene.add(spotlight);

scene.add(cube);
camera.position.set(0, 25, 0);
camera.lookAt(0, 0, 0);

const loader = new GLTFLoader();
loader.load("scene.glb", (gltf) => {
  const mesh = gltf.scene;
  mesh.traverse(function (child) {
    if (child.isMesh) {
      child.castShadow = true;
      child.receiveShadow = true;
    }
  });
  scene.add(mesh);
});

function animate() {
  requestAnimationFrame(animate);
  controls.update();
  renderer.render(scene, camera);
}

animate();
